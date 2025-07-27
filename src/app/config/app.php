<?php
/**
 * Application Configuration
 * Central configuration management for the application
 */

return [
    'app' => [
        'name' => 'Unggul Booking Hotel',
        'version' => '2.0.0',
        'env' => 'development', // development, production, testing
        'debug' => true,
        'timezone' => 'Asia/Jakarta',
        'locale' => 'id',
        'fallback_locale' => 'en',
        'url' => 'http://localhost:8000',
    ],

    'database' => [
        'default' => 'mysql',
        'connections' => [
            'mysql' => [
                'driver' => 'mysql',
                'host' => env('DB_HOST', 'localhost'),
                'port' => env('DB_PORT', 3306),
                'database' => env('DB_DATABASE', 'hotel_booking'),
                'username' => env('DB_USERNAME', 'root'),
                'password' => env('DB_PASSWORD', ''),
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'options' => [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            ]
        ]
    ],

    'session' => [
        'driver' => 'file',
        'lifetime' => 120, // minutes
        'expire_on_close' => false,
        'encrypt' => false,
        'files' => storage_path('sessions'),
        'connection' => null,
        'table' => 'sessions',
        'store' => null,
        'lottery' => [2, 100],
        'cookie' => [
            'name' => 'hotel_booking_session',
            'path' => '/',
            'domain' => null,
            'secure' => false,
            'http_only' => true,
            'same_site' => 'lax',
        ],
    ],

    'security' => [
        'csrf' => [
            'enabled' => true,
            'token_name' => '_token',
            'header_name' => 'X-CSRF-TOKEN',
        ],
        'password' => [
            'min_length' => 8,
            'require_uppercase' => false,
            'require_lowercase' => false,
            'require_numbers' => false,
            'require_symbols' => false,
        ],
        'rate_limiting' => [
            'enabled' => true,
            'max_attempts' => 5,
            'decay_minutes' => 15,
        ]
    ],

    'features' => [
        'hotel_booking' => [
            'enabled' => true,
            'max_favorites' => 50,
            'search_cache_ttl' => 300, // seconds
        ],
        'user_management' => [
            'enabled' => true,
            'allow_registration' => true,
            'email_verification' => false,
        ],
        'admin_dashboard' => [
            'enabled' => true,
            'cache_stats' => true,
            'stats_cache_ttl' => 600, // seconds
        ],
        'payment_processing' => [
            'enabled' => true,
            'sandbox_mode' => true,
            'supported_methods' => ['bca_va', 'qris', 'cod'],
        ]
    ],

    'logging' => [
        'default' => 'single',
        'channels' => [
            'single' => [
                'driver' => 'single',
                'path' => storage_path('logs/app.log'),
                'level' => 'debug',
            ],
            'daily' => [
                'driver' => 'daily',
                'path' => storage_path('logs/app.log'),
                'level' => 'debug',
                'days' => 14,
            ]
        ]
    ],

    'cache' => [
        'default' => 'file',
        'stores' => [
            'file' => [
                'driver' => 'file',
                'path' => storage_path('cache'),
            ],
            'redis' => [
                'driver' => 'redis',
                'connection' => 'cache',
            ]
        ]
    ],

    'mail' => [
        'default' => 'smtp',
        'mailers' => [
            'smtp' => [
                'transport' => 'smtp',
                'host' => env('MAIL_HOST', 'smtp.gmail.com'),
                'port' => env('MAIL_PORT', 587),
                'encryption' => env('MAIL_ENCRYPTION', 'tls'),
                'username' => env('MAIL_USERNAME'),
                'password' => env('MAIL_PASSWORD'),
            ]
        ],
        'from' => [
            'address' => env('MAIL_FROM_ADDRESS', 'noreply@unggulhotel.com'),
            'name' => env('MAIL_FROM_NAME', 'Unggul Booking Hotel'),
        ]
    ]
];

/**
 * Helper function to get environment variables
 */
function env($key, $default = null) {
    $value = $_ENV[$key] ?? getenv($key);
    
    if ($value === false) {
        return $default;
    }
    
    // Convert string booleans
    switch (strtolower($value)) {
        case 'true':
        case '(true)':
            return true;
        case 'false':
        case '(false)':
            return false;
        case 'empty':
        case '(empty)':
            return '';
        case 'null':
        case '(null)':
            return null;
    }
    
    return $value;
}

/**
 * Helper function to get storage path
 */
function storage_path($path = '') {
    $basePath = __DIR__ . '/../../storage';
    
    if (!is_dir($basePath)) {
        mkdir($basePath, 0755, true);
    }
    
    return $basePath . ($path ? DIRECTORY_SEPARATOR . $path : $path);
}
?>
