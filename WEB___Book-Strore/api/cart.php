<?php

session_start();
header('Content-Type: application/json; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $cart = isset($_SESSION['cart']) && is_array($_SESSION['cart']) ? $_SESSION['cart'] : [];
    echo json_encode(['cart' => $cart]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $action = isset($input['action']) ? $input['action'] : 'save';

    if ($action === 'save') {
        $cart = isset($input['cart']) && is_array($input['cart']) ? $input['cart'] : [];
        $validated = [];
        foreach ($cart as $item) {
            if (!is_array($item)) {
                continue;
            }
            $id = isset($item['id']) ? (int)$item['id'] : 0;
            $qty = isset($item['qty']) ? (int)$item['qty'] : 0;
            if ($id > 0 && $qty > 0) {
                $validated[] = ['id' => $id, 'qty' => $qty];
            }
        }
        $_SESSION['cart'] = $validated;
        echo json_encode(['success' => true, 'cart' => $validated]);
        exit;
    }

    if ($action === 'clear') {
        $_SESSION['cart'] = [];
        echo json_encode(['success' => true, 'cart' => []]);
        exit;
    }

    http_response_code(400);
    echo json_encode(['error' => 'Hành động không hợp lệ']);
    exit;
}

http_response_code(405);
echo json_encode(['error' => 'Method not allowed']);
