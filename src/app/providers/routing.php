<?php
/**
 * Router Provider
 * Handles application routing
 */

class RouterProvider {
    private $routes = [];
    
    public function get($path, $handler) {
        $this->routes['GET'][$path] = $handler;
    }
    
    public function post($path, $handler) {
        $this->routes['POST'][$path] = $handler;
    }
    
    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        if (isset($this->routes[$method][$path])) {
            $handler = $this->routes[$method][$path];
            if (is_callable($handler)) {
                call_user_func($handler);
            } else {
                include $handler;
            }
        } else {
            http_response_code(404);
            echo "Page not found";
        }
    }
    
    public function redirect($url) {
        header("Location: $url");
        exit;
    }
}
?>
