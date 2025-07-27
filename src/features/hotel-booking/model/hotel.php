<?php
/**
 * Hotel Model
 * Handles hotel data operations
 */

require_once __DIR__ . '/../../../app/providers/database.php';

class HotelModel {
    private $db;
    
    public function __construct() {
        $this->db = new DatabaseProvider();
    }
    
    /**
     * Get all hotels with optional filters
     */
    public function getAllHotels($filters = []) {
        // For now, return mock data. In production, this would query the database
        $hotels = [
            [
                'id' => 1,
                'name' => 'Hotel Trikora Beach',
                'location' => 'Bintan',
                'price' => 1200000,
                'user' => 'Robert',
                'image' => 'Hotel trikora beach.jpg',
                'rating' => 4.7,
                'description' => 'Beachfront resort with stunning views',
                'facilities' => ['WiFi', 'Pool', 'Beach Access', 'Restaurant']
            ],
            [
                'id' => 2,
                'name' => 'Hotel Santika Prime',
                'location' => 'Harapan Indah Bekasi',
                'price' => 688750,
                'user' => 'Larry Naves',
                'image' => 'HotelSantika.jpg',
                'rating' => 4.5,
                'description' => 'Luxury hotel with modern amenities',
                'facilities' => ['WiFi', 'Pool', 'Gym', 'Restaurant', 'Spa']
            ],
            [
                'id' => 3,
                'name' => 'Hotel Royal Ambarukmo',
                'location' => 'Jogjakarta',
                'price' => 1588755,
                'user' => 'Robert',
                'image' => 'royal-ambarukmo.jpg',
                'rating' => 4.8,
                'description' => 'Historic luxury hotel in Yogyakarta',
                'facilities' => ['WiFi', 'Pool', 'Heritage Tours', 'Restaurant']
            ],
            [
                'id' => 4,
                'name' => 'Hotel Novotel',
                'location' => 'Bandung',
                'price' => 653801,
                'user' => 'Jessica',
                'image' => 'HotelNovotel.jpg',
                'rating' => 4.6,
                'description' => 'Contemporary comfort in Bandung',
                'facilities' => ['WiFi', 'Pool', 'Business Center', 'Restaurant']
            ],
            [
                'id' => 5,
                'name' => 'Hotel Fairfield',
                'location' => 'Bali',
                'price' => 1131350,
                'user' => 'Jefri Nichol',
                'image' => 'fairfield.jpg',
                'rating' => 4.7,
                'description' => 'Beachfront paradise in Bali',
                'facilities' => ['WiFi', 'Pool', 'Beach Access', 'Restaurant', 'Spa']
            ],
            [
                'id' => 6,
                'name' => 'Hotel Kempinski',
                'location' => 'Jakarta Pusat',
                'price' => 2688750,
                'user' => 'Marco Van Basten',
                'image' => 'HotelKempinski.jpg',
                'rating' => 4.9,
                'description' => 'Luxury 5-star hotel in central Jakarta',
                'facilities' => ['WiFi', 'Pool', 'Concierge', 'Restaurant', 'Spa', 'Business Center']
            ]
        ];
        
        // Apply filters
        if (!empty($filters['location']) && $filters['location'] !== 'all') {
            $hotels = array_filter($hotels, function($hotel) use ($filters) {
                return stripos($hotel['location'], $filters['location']) !== false;
            });
        }
        
        if (!empty($filters['search'])) {
            $hotels = array_filter($hotels, function($hotel) use ($filters) {
                return stripos($hotel['name'], $filters['search']) !== false ||
                       stripos($hotel['location'], $filters['search']) !== false;
            });
        }
        
        if (!empty($filters['min_price'])) {
            $hotels = array_filter($hotels, function($hotel) use ($filters) {
                return $hotel['price'] >= $filters['min_price'];
            });
        }
        
        if (!empty($filters['max_price'])) {
            $hotels = array_filter($hotels, function($hotel) use ($filters) {
                return $hotel['price'] <= $filters['max_price'];
            });
        }
        
        return array_values($hotels);
    }
    
    /**
     * Get hotel by ID
     */
    public function getHotelById($id) {
        $hotels = $this->getAllHotels();
        
        foreach ($hotels as $hotel) {
            if ($hotel['id'] == $id) {
                return $hotel;
            }
        }
        
        return null;
    }
    
    /**
     * Get popular hotels
     */
    public function getPopularHotels($limit = 4) {
        $hotels = $this->getAllHotels();
        
        // Sort by rating descending
        usort($hotels, function($a, $b) {
            return $b['rating'] <=> $a['rating'];
        });
        
        return array_slice($hotels, 0, $limit);
    }
    
    /**
     * Get hotels by location
     */
    public function getHotelsByLocation($location) {
        return $this->getAllHotels(['location' => $location]);
    }
    
    /**
     * Search hotels
     */
    public function searchHotels($query) {
        return $this->getAllHotels(['search' => $query]);
    }
    
    /**
     * Get hotel room types
     */
    public function getHotelRooms($hotelId) {
        // Mock room data
        return [
            [
                'id' => 1,
                'hotel_id' => $hotelId,
                'type' => 'Standard Room',
                'price' => 500000,
                'capacity' => 2,
                'facilities' => ['WiFi', 'AC', 'TV', 'Private Bathroom'],
                'images' => ['room1.jpg', 'room2.jpg']
            ],
            [
                'id' => 2,
                'hotel_id' => $hotelId,
                'type' => 'Deluxe Room',
                'price' => 750000,
                'capacity' => 2,
                'facilities' => ['WiFi', 'AC', 'TV', 'Private Bathroom', 'Balcony'],
                'images' => ['room3.jpg', 'room4.jpg']
            ],
            [
                'id' => 3,
                'hotel_id' => $hotelId,
                'type' => 'Suite',
                'price' => 1200000,
                'capacity' => 4,
                'facilities' => ['WiFi', 'AC', 'TV', 'Private Bathroom', 'Living Room', 'Kitchen'],
                'images' => ['suite1.jpg', 'suite2.jpg']
            ]
        ];
    }
    
    /**
     * Check room availability
     */
    public function checkAvailability($hotelId, $roomType, $checkIn, $checkOut) {
        // Mock availability check
        // In production, this would check against bookings table
        return rand(1, 10); // Return random available rooms
    }
    
    /**
     * Add hotel to favorites
     */
    public function addToFavorites($userId, $hotelId) {
        if (!$this->db->getConnection()) {
            return false;
        }
        
        return $this->db->insert('favorites', [
            'user_id' => $userId,
            'hotel_id' => $hotelId,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
    
    /**
     * Remove hotel from favorites
     */
    public function removeFromFavorites($userId, $hotelId) {
        if (!$this->db->getConnection()) {
            return false;
        }
        
        return $this->db->delete('favorites', [
            'user_id' => $userId,
            'hotel_id' => $hotelId
        ]);
    }
    
    /**
     * Get user's favorite hotels
     */
    public function getUserFavorites($userId) {
        if (!$this->db->getConnection()) {
            return [];
        }
        
        $stmt = $this->db->query(
            "SELECT h.* FROM hotels h 
             JOIN favorites f ON h.id = f.hotel_id 
             WHERE f.user_id = :user_id",
            ['user_id' => $userId]
        );
        
        return $stmt ? $stmt->fetchAll() : [];
    }
}
?>
