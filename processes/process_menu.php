<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../pages/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../pages/menu.php");
    exit();
}

include "../config/db.php";
require_once __DIR__ . '/../includes/cart_functions.php';

$userId = isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : 0;
ensureSessionCartInitialized($conn, $userId);

$allowedRedirects = [
    '../pages/menu.php',
    '../pages/orders.php'
];

$redirect = isset($_POST['redirect']) && in_array($_POST['redirect'], $allowedRedirects, true)
    ? $_POST['redirect']
    : '../pages/menu.php';

function setCartFeedback(string $type, string $message): void {
    $_SESSION['cart_feedback'] = [
        'type' => $type,
        'message' => $message
    ];
}

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'add_to_cart':
        $itemId = isset($_POST['item_id']) ? (int) $_POST['item_id'] : 0;
        $quantity = isset($_POST['quantity']) ? max(1, (int) $_POST['quantity']) : 1;

        $stmt = $conn->prepare("SELECT item_id, item_name, price, stock FROM menu_items WHERE item_id = ? AND status = 'active'");
        $stmt->bind_param("i", $itemId);
        $stmt->execute();
        $item = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$item) {
            setCartFeedback('danger', 'Selected item is unavailable.');
            break;
        }

        if ((int) $item['stock'] <= 0) {
            setCartFeedback('danger', 'This item is currently out of stock.');
            break;
        }

        $existingQty = isset($_SESSION['cart'][$itemId]) ? (int) $_SESSION['cart'][$itemId]['quantity'] : 0;
        $maxAllowed = (int) $item['stock'];
        $newQty = min($existingQty + $quantity, $maxAllowed);

        $cartId = getOrCreateUserCartId($conn, $userId);
        if (!$cartId) {
            setCartFeedback('danger', 'Unable to access your cart at the moment. Please try again.');
            break;
        }

        $subtotal = (float) $item['price'] * $newQty;

        $itemStmt = $conn->prepare("SELECT cart_item_id FROM cart_items WHERE cart_id = ? AND item_id = ?");
        $itemStmt->bind_param("ii", $cartId, $itemId);
        $itemStmt->execute();
        $existingItem = $itemStmt->get_result()->fetch_assoc();
        $itemStmt->close();

        if ($existingItem) {
            $updateStmt = $conn->prepare("UPDATE cart_items SET quantity = ?, subtotal = ? WHERE cart_item_id = ?");
            if (!$updateStmt) {
                setCartFeedback('danger', 'Unable to update your cart. Please try again.');
                break;
            }
            $updateStmt->bind_param("idi", $newQty, $subtotal, $existingItem['cart_item_id']);
            if (!$updateStmt->execute()) {
                $updateStmt->close();
                setCartFeedback('danger', 'Unable to update your cart. Please try again.');
                break;
            }
            $updateStmt->close();
        } else {
            $insertStmt = $conn->prepare("INSERT INTO cart_items (cart_id, item_id, quantity, subtotal) VALUES (?, ?, ?, ?)");
            if (!$insertStmt) {
                setCartFeedback('danger', 'Unable to add the item to your cart right now.');
                break;
            }
            $insertStmt->bind_param("iiid", $cartId, $itemId, $newQty, $subtotal);
            if (!$insertStmt->execute()) {
                $insertStmt->close();
                setCartFeedback('danger', 'Unable to add the item to your cart right now.');
                break;
            }
            $insertStmt->close();
        }

        refreshSessionCart($conn, $userId);

        $message = $newQty === ($existingQty + $quantity)
            ? "{$item['item_name']} added to your cart."
            : "Quantity updated. Maximum available stock is {$item['stock']}.";
        setCartFeedback('success', $message);
        break;

    case 'update_quantity':
        $itemId = isset($_POST['item_id']) ? (int) $_POST['item_id'] : 0;
        $quantity = isset($_POST['quantity']) ? (int) $_POST['quantity'] : 1;

        if (!isset($_SESSION['cart'][$itemId])) {
            setCartFeedback('danger', 'Item not found in cart.');
            break;
        }

        $cartId = getOrCreateUserCartId($conn, $userId);
        if (!$cartId) {
            setCartFeedback('danger', 'Unable to update your cart at the moment.');
            break;
        }

        if ($quantity <= 0) {
            $removeStmt = $conn->prepare("DELETE FROM cart_items WHERE cart_id = ? AND item_id = ?");
            if ($removeStmt) {
                $removeStmt->bind_param("ii", $cartId, $itemId);
                $removeStmt->execute();
                $removeStmt->close();
            }
            refreshSessionCart($conn, $userId);
            setCartFeedback('success', 'Item removed from your cart.');
            break;
        }

        $stmt = $conn->prepare("SELECT price, stock FROM menu_items WHERE item_id = ? AND status = 'active'");
        $stmt->bind_param("i", $itemId);
        $stmt->execute();
        $item = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$item) {
            $cleanupStmt = $conn->prepare("DELETE FROM cart_items WHERE cart_id = ? AND item_id = ?");
            if ($cleanupStmt) {
                $cleanupStmt->bind_param("ii", $cartId, $itemId);
                $cleanupStmt->execute();
                $cleanupStmt->close();
            }
            refreshSessionCart($conn, $userId);
            setCartFeedback('danger', 'Item is no longer available and was removed from your cart.');
            break;
        }

        $maxAllowed = (int) $item['stock'];
        $newQty = min($quantity, $maxAllowed);

        $subtotal = (float) $item['price'] * $newQty;
        $updateStmt = $conn->prepare("UPDATE cart_items SET quantity = ?, subtotal = ? WHERE cart_id = ? AND item_id = ?");
        if (!$updateStmt) {
            setCartFeedback('danger', 'Unable to update your cart. Please try again.');
            break;
        }

        $updateStmt->bind_param("idii", $newQty, $subtotal, $cartId, $itemId);
        if (!$updateStmt->execute()) {
            $updateStmt->close();
            setCartFeedback('danger', 'Unable to update your cart. Please try again.');
            break;
        }
        $updateStmt->close();

        refreshSessionCart($conn, $userId);

        $feedbackType = $quantity > $maxAllowed ? 'warning' : 'success';
        $message = $quantity > $maxAllowed
            ? "Quantity adjusted to available stock ({$item['stock']})."
            : "Quantity updated.";
        setCartFeedback($feedbackType, $message);
        break;

    case 'remove_item':
        $itemId = isset($_POST['item_id']) ? (int) $_POST['item_id'] : 0;
        $cartId = getOrCreateUserCartId($conn, $userId);
        $hadItem = isset($_SESSION['cart'][$itemId]);
        if ($cartId) {
            $removeStmt = $conn->prepare("DELETE FROM cart_items WHERE cart_id = ? AND item_id = ?");
            if ($removeStmt) {
                $removeStmt->bind_param("ii", $cartId, $itemId);
                $removeStmt->execute();
                $removeStmt->close();
            }
        }
        refreshSessionCart($conn, $userId);
        if ($hadItem) {
            setCartFeedback('success', 'Item removed from your cart.');
        } else {
            setCartFeedback('danger', 'Item not found in cart.');
        }
        break;

    case 'clear_cart':
        $cartId = getOrCreateUserCartId($conn, $userId);
        if ($cartId) {
            $clearStmt = $conn->prepare("DELETE FROM cart_items WHERE cart_id = ?");
            if ($clearStmt) {
                $clearStmt->bind_param("i", $cartId);
                $clearStmt->execute();
                $clearStmt->close();
            }
        }
        refreshSessionCart($conn, $userId);
        setCartFeedback('success', 'Cart cleared.');
        break;

    default:
        setCartFeedback('danger', 'Invalid action.');
        break;
}

$conn->close();
header("Location: {$redirect}");
exit();
