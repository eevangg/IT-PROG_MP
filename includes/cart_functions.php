<?php

/**
 * Ensures a cart row exists for the current user and returns its ID.
 */
function getOrCreateUserCartId(mysqli $conn, int $userId): ?int
{
    if ($userId <= 0) {
        return null;
    }

    $cartId = null;
    $stmt = $conn->prepare("SELECT cart_id FROM cart WHERE user_id = ? LIMIT 1");
    if ($stmt) {
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->bind_result($cartId);
        $stmt->fetch();
        $stmt->close();
    }

    if ($cartId) {
        return (int) $cartId;
    }

    $insertStmt = $conn->prepare("INSERT INTO cart (user_id) VALUES (?)");
    if (!$insertStmt) {
        return null;
    }

    $insertStmt->bind_param("i", $userId);
    if ($insertStmt->execute()) {
        $cartId = $insertStmt->insert_id;
    }
    $insertStmt->close();

    return $cartId ? (int) $cartId : null;
}

/**
 * Loads all cart items for a user and returns a normalized array keyed by item_id.
 */
function loadCartForUser(mysqli $conn, int $userId): array
{
    $cartData = [];
    if ($userId <= 0) {
        return $cartData;
    }

    $cartId = getOrCreateUserCartId($conn, $userId);
    if (!$cartId) {
        return $cartData;
    }

    $sql = "
        SELECT ci.item_id, ci.quantity, mi.item_name, mi.price, mp.plan_id, mp.day_of_week, mp.week_start, mp.available_qty, mi.category
        FROM cart_items ci
        JOIN menu_items mi ON ci.item_id = mi.item_id
        LEFT JOIN meal_plans mp ON mp.plan_id = ci.plan_id
        WHERE ci.cart_id = ? 
        ORDER BY mi.item_name ASC
    ";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        return $cartData;
    }

    $stmt->bind_param("i", $cartId);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $itemId = (int) $row['item_id'];
        $planId = (int) $row['plan_id'];

        // Convert day string → number
        $dayName = $row['day_of_week'];
        $weekStart = $row['week_start'];

        $dayMap = [
            "Monday"    => 1,
            "Tuesday"   => 2,
            "Wednesday" => 3,
            "Thursday"  => 4,
            "Friday"    => 5,
            "Saturday"  => 6,
            "Sunday"    => 7
        ];

        // Safeguard: If day is missing or invalid, assume Monday
        $dayNumber = $dayMap[$dayName] ?? 1;

        // Calculate the exact date
        $exactDate = date(
            'Y-m-d',
            strtotime("$weekStart + " . ($dayNumber - 1) . " days")
        );

        $cartData[$itemId][$planId] = [
            'item_id' => $itemId,
            'plan_id' => $planId,
            'name' => $row['item_name'],
            'price' => (float) $row['price'],
            'stock' => (int) $row['available_qty'],
            'quantity' => (int) $row['quantity'],
            'category' => $row['category'],
            'week' => $row['week_start'],
            'day' =>  $row['day_of_week'],
            'date' => $exactDate
        ];
    }
    $stmt->close();

    return $cartData;
}

/**
 * Refreshes the $_SESSION['cart'] content from the database.
 */
function refreshSessionCart(mysqli $conn, int $userId): void
{
    if ($userId <= 0) {
        $_SESSION['cart'] = [];
        unset($_SESSION['cart_loaded_from_db']);
        return;
    }

    $_SESSION['cart'] = loadCartForUser($conn, $userId);
    $_SESSION['cart_loaded_from_db'] = true;
}

/**
 * Ensures the in-memory cart is populated from the database once per session.
 */
function ensureSessionCartInitialized(mysqli $conn, int $userId): void
{
    if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $alreadyLoaded = isset($_SESSION['cart_loaded_from_db']) && $_SESSION['cart_loaded_from_db'] === true;
    if ($userId > 0 && !$alreadyLoaded) {
        refreshSessionCart($conn, $userId);
    }
}
