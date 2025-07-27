<?php
/**
 * Main Application Entry Point
 * Following Feature-Sliced Design (FSD) Architecture
 * 
 * @version 2.0.0
 * @author whympxx
 */

require_once __DIR__ . '/providers/routing.php';
require_once __DIR__ . '/providers/database.php';
require_once __DIR__ . '/providers/auth.php';

// Initialize application
$app = new Application();
$app->initialize();
$app->run();

class Application {
    private $router;
    private $database;
    private $auth;
    
    public function initialize() {
        $this->initializeProviders();
        $this->loadRoutes();
    }
    
    private function initializeProviders() {
        $this->database = new DatabaseProvider();
        $this->auth = new AuthProvider();
        $this->router = new RouterProvider();
    }
    
    private function loadRoutes() {
        // Load feature routes
        require_once __DIR__ . '/../features/hotel-booking/routes.php';
        require_once __DIR__ . '/../features/user-management/routes.php';
        require_once __DIR__ . '/../features/admin-dashboard/routes.php';
        require_once __DIR__ . '/../features/agent-management/routes.php';
        require_once __DIR__ . '/../features/payment-processing/routes.php';
    }
    
    public function run() {
        $this->router->dispatch();
    }
}
?>
