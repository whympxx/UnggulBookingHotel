<?php
// get_hotels.php
session_start();

// Set header untuk JSON response
header('Content-Type: application/json');

// Fungsi untuk membaca data hotel
function getHotels($search = '', $rating = '') {
    $hotels_file = 'hotels_data.json';
    $hotels = [];
    
    if (file_exists($hotels_file)) {
        $hotels = json_decode(file_get_contents($hotels_file), true) ?? [];
    }
    
    // Filter berdasarkan search
    if (!empty($search)) {
        $hotels = array_filter($hotels, function($hotel) use ($search) {
            return stripos($hotel['name'], $search) !== false || 
                   stripos($hotel['location'], $search) !== false;
        });
    }
    
    // Filter berdasarkan rating
    if (!empty($rating)) {
        $hotels = array_filter($hotels, function($hotel) use ($rating) {
            return $hotel['rating'] == $rating;
        });
    }
    
    return array_values($hotels);
}

// Cek apakah request method adalah GET
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    try {
        $search = $_GET['search'] ?? '';
        $rating = $_GET['rating'] ?? '';
        
        $hotels = getHotels($search, $rating);
        
        // Response sukses
        echo json_encode([
            'success' => true,
            'data' => $hotels,
            'total' => count($hotels)
        ]);
        
    } catch (Exception $e) {
        // Response error
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
} else {
    // Method tidak diizinkan
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Method tidak diizinkan'
    ]);
}
?> 