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

if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

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

        $_SESSION['cart'][$itemId] = [
            'item_id' => $item['item_id'],
            'name' => $item['item_name'],
            'price' => $item['price'],
            'stock' => $item['stock'],
            'quantity' => $newQty
        ];

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

        if ($quantity <= 0) {
            unset($_SESSION['cart'][$itemId]);
            setCartFeedback('success', 'Item removed from your cart.');
            break;
        }

        $stmt = $conn->prepare("SELECT stock FROM menu_items WHERE item_id = ? AND status = 'active'");
        $stmt->bind_param("i", $itemId);
        $stmt->execute();
        $item = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$item) {
            unset($_SESSION['cart'][$itemId]);
            setCartFeedback('danger', 'Item is no longer available and was removed from your cart.');
            break;
        }

        $maxAllowed = (int) $item['stock'];
        $newQty = min($quantity, $maxAllowed);
        $_SESSION['cart'][$itemId]['quantity'] = $newQty;
        $_SESSION['cart'][$itemId]['stock'] = $item['stock'];

        $feedbackType = $quantity > $maxAllowed ? 'warning' : 'success';
        $message = $quantity > $maxAllowed
            ? "Quantity adjusted to available stock ({$item['stock']})."
            : "Quantity updated.";
        setCartFeedback($feedbackType, $message);
        break;

    case 'remove_item':
        $itemId = isset($_POST['item_id']) ? (int) $_POST['item_id'] : 0;
        if (isset($_SESSION['cart'][$itemId])) {
            unset($_SESSION['cart'][$itemId]);
            setCartFeedback('success', 'Item removed from your cart.');
        } else {
            setCartFeedback('danger', 'Item not found in cart.');
        }
        break;

    case 'clear_cart':
        unset($_SESSION['cart']);
        setCartFeedback('success', 'Cart cleared.');
        break;

    default:
        setCartFeedback('danger', 'Invalid action.');
        break;
}

$conn->close();
header("Location: {$redirect}");
exit();
