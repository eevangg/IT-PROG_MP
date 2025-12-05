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
        $planId = isset($_POST['plan_id']) ? (int) $_POST['plan_id'] : 0;

        $sql = "SELECT m.item_id, m.item_name, m.price, mp.available_qty 
                FROM menu_items m
                JOIN meal_plans mp ON m.item_id = mp.item_id
                WHERE m.item_id = ? AND mp.plan_id = ? AND m.status = 'active'";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $itemId, $planId);
        $stmt->execute();
        $item = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$item) {
            setCartFeedback('danger', 'Selected item is unavailable.');
            break;
        }

        if ((int) $item['available_qty'] <= 0) {
            setCartFeedback('danger', 'This item is currently unavailable for the chosen day.');
            break;
        }

        $existingQty = isset($_SESSION['cart'][$itemId][$planId]) ? (int) $_SESSION['cart'][$itemId][$planId]['quantity'] : 0;
        $maxAllowed = (int) $item['available_qty'];
        $newQty = min($existingQty + $quantity, $maxAllowed);

        $cartId = getOrCreateUserCartId($conn, $userId);
        if (!$cartId) {
            setCartFeedback('danger', 'Unable to access your cart at the moment. Please try again.');
            break;
        }

        $subtotal = (float) $item['price'] * $newQty;

        $itemStmt = $conn->prepare("SELECT cart_item_id FROM cart_items WHERE cart_id = ? AND item_id = ? AND plan_id = ?");
        $itemStmt->bind_param("iii", $cartId, $itemId, $planId);
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
            $insertStmt = $conn->prepare("INSERT INTO cart_items (cart_id, plan_id, item_id, quantity, subtotal) VALUES (?, ?, ?, ?, ?)");
            if (!$insertStmt) {
                setCartFeedback('danger', 'Unable to add the item to your cart right now.');
                break;
            }
            $insertStmt->bind_param("iiiid", $cartId, $planId, $itemId, $newQty, $subtotal);
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
            : "Quantity updated. Maximum available quantity is {$item['available_qty']}.";
        setCartFeedback('success', $message);
        break;

    case 'update_quantity':
        $itemId = isset($_POST['item_id']) ? (int) $_POST['item_id'] : 0;
        $quantity = isset($_POST['quantity']) ? (int) $_POST['quantity'] : 1;
        $planId = isset($_POST['plan_id']) ? (int) $_POST['plan_id'] : 0;

        if (!isset($_SESSION['cart'][$itemId][$planId])) {
            setCartFeedback('danger', 'Item not found in cart.');
            break;
        }

        $cartId = getOrCreateUserCartId($conn, $userId);
        if (!$cartId) {
            setCartFeedback('danger', 'Unable to update your cart at the moment.');
            break;
        }

        if ($quantity <= 0) {
            $removeStmt = $conn->prepare("DELETE FROM cart_items WHERE cart_id = ? AND item_id = ? AND plan_id = ?");
            if ($removeStmt) {
                $removeStmt->bind_param("iii", $cartId, $itemId, $planId);
                $removeStmt->execute();
                $removeStmt->close();
            }
            refreshSessionCart($conn, $userId);
            setCartFeedback('success', 'Item removed from your cart.');
            break;
        }

        $sql = "SELECT m.price, mp.available_qty 
                FROM menu_items m
                JOIN meal_plans mp ON m.item_id = mp.item_id
                WHERE m.item_id = ? AND mp.plan_id = ? AND m.status = 'active'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $itemId, $planId);
        $stmt->execute();
        $item = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$item) {
            $cleanupStmt = $conn->prepare("DELETE FROM cart_items WHERE cart_id = ? AND item_id = ? AND plan_id = ?");
            if ($cleanupStmt) {
                $cleanupStmt->bind_param("iii", $cartId, $itemId, $planId);
                $cleanupStmt->execute();
                $cleanupStmt->close();
            }
            refreshSessionCart($conn, $userId);
            setCartFeedback('danger', 'Item is no longer available and was removed from your cart.');
            break;
        }

        $maxAllowed = (int) $item['available_qty'];
        $newQty = min($quantity, $maxAllowed);

        $subtotal = (float) $item['price'] * $newQty;
        $updateStmt = $conn->prepare("UPDATE cart_items SET quantity = ?, subtotal = ? WHERE cart_id = ? AND item_id = ? AND plan_id = ?");
        if (!$updateStmt) {
            setCartFeedback('danger', 'Unable to update your cart. Please try again.');
            break;
        }

        $updateStmt->bind_param("idiii", $newQty, $subtotal, $cartId, $itemId, $planId);
        if (!$updateStmt->execute()) {
            $updateStmt->close();
            setCartFeedback('danger', 'Unable to update your cart. Please try again.');
            break;
        }
        $updateStmt->close();

        refreshSessionCart($conn, $userId);

        $feedbackType = $quantity > $maxAllowed ? 'warning' : 'success';
        $message = $quantity > $maxAllowed
            ? "Quantity adjusted to available quantity ({$item['available_qty']})."
            : "Quantity updated.";
        setCartFeedback($feedbackType, $message);
        break;

    case 'remove_item':
        $itemId = isset($_POST['item_id']) ? (int) $_POST['item_id'] : 0;
        $cartId = getOrCreateUserCartId($conn, $userId);
        $planId = isset($_POST['plan_id']) ? (int) $_POST['plan_id'] : 0;
        $hadItem = isset($_SESSION['cart'][$itemId][$planId]);
        if ($cartId) {
            $removeStmt = $conn->prepare("DELETE FROM cart_items WHERE cart_id = ? AND item_id = ? AND plan_id = ?");
            if ($removeStmt) {
                $removeStmt->bind_param("iii", $cartId, $itemId, $planId);
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
