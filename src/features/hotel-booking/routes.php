<?php
/**
 * Hotel Booking Routes
 * Defines routes for hotel booking feature
 */

require_once __DIR__ . '/model/hotel.php';
require_once __DIR__ . '/../../shared/ui/components/header.php';
require_once __DIR__ . '/../../shared/lib/utils.php';

$router->get('/', function() {
    $model = new HotelModel();
    $hotels = $model->getAllHotels();

    include __DIR__ . '/view/hotels.php';
});

$router->get('hotels', function() {
    $model = new HotelModel();
    
    $filters = [
        'location' => $_GET['location'] ?? 'all',
        'search' => $_GET['search'] ?? '',
    ];
    $hotels = $model->getAllHotels($filters);
    
    // Respond with JSON for API requests
    if (isset($_GET['as_json'])) {
        Utils::jsonResponse(['hotels' => $hotels]);
    }
    
    include __DIR__ . '/view/hotels.php';
});

$router->get('hotel/{id}', function($id) {
    $model = new HotelModel();
    $hotel = $model->getHotelById($id);
    
    if (!$hotel) {
        http_response_code(404);
        echo "Hotel not found";
        return;
    }
    
    $rooms = $model->getHotelRooms($id);
    include __DIR__ . '/view/hotel_details.php';
});

$router->post('hotel/{id}/favorite', function($id) {
    $auth = new AuthProvider();
    $user = $auth->getCurrentUser();
    
    if (!$user) {
        http_response_code(401);
        Utils::jsonResponse(['error' => 'User not authenticated'], 401);
    }
    
    $model = new HotelModel();
    $success = $model->addToFavorites($user['id'], $id);

    if ($success) {
        Utils::jsonResponse(['success' => true]);
    } else {
        Utils::jsonResponse(['error' => 'Failed to add to favorites'], 400);
    }
});

$router->post('hotel/{id}/unfavorite', function($id) {
    $auth = new AuthProvider();
    $user = $auth->getCurrentUser();
    
    if (!$user) {
        http_response_code(401);
        Utils::jsonResponse(['error' => 'User not authenticated'], 401);
    }
    
    $model = new HotelModel();
    $success = $model->removeFromFavorites($user['id'], $id);
    
    if ($success) {
        Utils::jsonResponse(['success' => true]);
    } else {
        Utils::jsonResponse(['error' => 'Failed to remove from favorites'], 400);
    }
});

?>
