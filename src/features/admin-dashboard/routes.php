<?php
/**
 * Admin Dashboard Routes
 * Handles admin-specific functionality
 */

// Admin Dashboard
$router->get('/admin', function() {
    $auth = new AuthProvider();
    $auth->requireRole('admin');
    
    // Get dashboard statistics
    $stats = [
        'total_hotels' => 15,
        'total_bookings' => 127,
        'total_users' => 89,
        'total_agents' => 12,
        'monthly_revenue' => 25750000
    ];
    
    include __DIR__ . '/view/dashboard.php';
});

// Admin Hotel Management
$router->get('/admin/hotels', function() {
    $auth = new AuthProvider();
    $auth->requireRole('admin');
    
    $hotelModel = new HotelModel();
    $hotels = $hotelModel->getAllHotels();
    
    include __DIR__ . '/view/hotels.php';
});

// Admin User Management
$router->get('/admin/users', function() {
    $auth = new AuthProvider();
    $auth->requireRole('admin');
    
    // Get all users (mock data for now)
    $users = [
        ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com', 'role' => 'user'],
        ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com', 'role' => 'agent'],
    ];
    
    include __DIR__ . '/view/users.php';
});

// Admin Agent Management
$router->get('/admin/agents', function() {
    $auth = new AuthProvider();
    $auth->requireRole('admin');
    
    // Get all agents (mock data for now)
    $agents = [
        ['id' => 1, 'name' => 'Robert', 'email' => 'robert@example.com', 'hotels_count' => 3],
        ['id' => 2, 'name' => 'Jessica', 'email' => 'jessica@example.com', 'hotels_count' => 2],
    ];
    
    include __DIR__ . '/view/agents.php';
});

// Admin Settings
$router->get('/admin/settings', function() {
    $auth = new AuthProvider();
    $auth->requireRole('admin');
    
    include __DIR__ . '/view/settings.php';
});
?>
