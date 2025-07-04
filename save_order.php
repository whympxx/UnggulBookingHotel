<?php
// save_order.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if ($data) {
        $ordersFile = 'orders_data.json';
        $orders = file_exists($ordersFile) ? json_decode(file_get_contents($ordersFile), true) : [];
        // Tambahkan ID otomatis
        $data['id'] = count($orders) + 1;
        $orders[] = $data;
        file_put_contents($ordersFile, json_encode($orders, JSON_PRETTY_PRINT));
        http_response_code(200);
        echo json_encode(['success' => true]);
        exit;
    }
}
http_response_code(400);
echo json_encode(['success' => false, 'message' => 'Invalid data']); 