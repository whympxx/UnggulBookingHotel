<?php
/**
 * Application Exception Classes
 * Custom exception handling for better error management
 */

namespace App\Exceptions;

/**
 * Base Application Exception
 */
class AppException extends \Exception {
    protected $statusCode = 500;
    protected $errorCode = 'APP_ERROR';
    protected $context = [];

    public function __construct(string $message = '', int $code = 0, \Throwable $previous = null, array $context = []) {
        parent::__construct($message, $code, $previous);
        $this->context = $context;
    }

    public function getStatusCode(): int {
        return $this->statusCode;
    }

    public function getErrorCode(): string {
        return $this->errorCode;
    }

    public function getContext(): array {
        return $this->context;
    }

    public function setContext(array $context): self {
        $this->context = $context;
        return $this;
    }

    public function toArray(): array {
        return [
            'error' => true,
            'error_code' => $this->errorCode,
            'message' => $this->getMessage(),
            'status_code' => $this->statusCode,
            'context' => $this->context,
        ];
    }
}

/**
 * Validation Exception
 */
class ValidationException extends AppException {
    protected $statusCode = 422;
    protected $errorCode = 'VALIDATION_ERROR';
    protected $errors = [];

    public function __construct(array $errors, string $message = 'Validation failed') {
        $this->errors = $errors;
        parent::__construct($message);
    }

    public function getErrors(): array {
        return $this->errors;
    }

    public function toArray(): array {
        $data = parent::toArray();
        $data['errors'] = $this->errors;
        return $data;
    }
}

/**
 * Authentication Exception
 */
class AuthenticationException extends AppException {
    protected $statusCode = 401;
    protected $errorCode = 'AUTH_ERROR';

    public function __construct(string $message = 'Authentication required') {
        parent::__construct($message);
    }
}

/**
 * Authorization Exception
 */
class AuthorizationException extends AppException {
    protected $statusCode = 403;
    protected $errorCode = 'AUTHORIZATION_ERROR';

    public function __construct(string $message = 'Access denied') {
        parent::__construct($message);
    }
}

/**
 * Not Found Exception
 */
class NotFoundException extends AppException {
    protected $statusCode = 404;
    protected $errorCode = 'NOT_FOUND';

    public function __construct(string $resource = 'Resource', string $identifier = '') {
        $message = $resource . ' not found';
        if (!empty($identifier)) {
            $message .= ": {$identifier}";
        }
        parent::__construct($message);
    }
}

/**
 * Database Exception
 */
class DatabaseException extends AppException {
    protected $statusCode = 500;
    protected $errorCode = 'DATABASE_ERROR';

    public function __construct(string $message = 'Database operation failed', \Throwable $previous = null) {
        parent::__construct($message, 0, $previous);
    }
}

/**
 * Configuration Exception
 */
class ConfigurationException extends AppException {
    protected $statusCode = 500;
    protected $errorCode = 'CONFIG_ERROR';

    public function __construct(string $message = 'Configuration error') {
        parent::__construct($message);
    }
}

/**
 * Rate Limit Exception
 */
class RateLimitException extends AppException {
    protected $statusCode = 429;
    protected $errorCode = 'RATE_LIMIT_EXCEEDED';

    public function __construct(string $message = 'Rate limit exceeded') {
        parent::__construct($message);
    }
}

/**
 * File Exception
 */
class FileException extends AppException {
    protected $statusCode = 400;
    protected $errorCode = 'FILE_ERROR';

    public function __construct(string $message = 'File operation failed') {
        parent::__construct($message);
    }
}

/**
 * Exception Handler
 */
class ExceptionHandler {
    private $config;
    private $logger;

    public function __construct($config = null, $logger = null) {
        $this->config = $config;
        $this->logger = $logger;
    }

    public function handle(\Throwable $exception): void {
        // Log the exception
        $this->logException($exception);

        // Handle different types of exceptions
        if ($exception instanceof AppException) {
            $this->handleAppException($exception);
        } else {
            $this->handleGenericException($exception);
        }
    }

    private function handleAppException(AppException $exception): void {
        http_response_code($exception->getStatusCode());
        header('Content-Type: application/json');

        $response = $exception->toArray();
        
        // Don't expose sensitive information in production
        if ($this->isProduction()) {
            unset($response['context']);
            if ($exception->getStatusCode() >= 500) {
                $response['message'] = 'Internal server error';
            }
        }

        echo json_encode($response, JSON_PRETTY_PRINT);
    }

    private function handleGenericException(\Throwable $exception): void {
        http_response_code(500);
        header('Content-Type: application/json');

        $response = [
            'error' => true,
            'error_code' => 'INTERNAL_ERROR',
            'message' => $this->isProduction() ? 'Internal server error' : $exception->getMessage(),
        ];

        if (!$this->isProduction()) {
            $response['file'] = $exception->getFile();
            $response['line'] = $exception->getLine();
            $response['trace'] = $exception->getTraceAsString();
        }

        echo json_encode($response, JSON_PRETTY_PRINT);
    }

    private function logException(\Throwable $exception): void {
        if ($this->logger) {
            $this->logger->error($exception->getMessage(), [
                'exception' => $exception,
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'trace' => $exception->getTraceAsString(),
            ]);
        } else {
            // Fallback logging
            error_log(sprintf(
                "[%s] %s in %s:%d\nStack trace:\n%s",
                date('Y-m-d H:i:s'),
                $exception->getMessage(),
                $exception->getFile(),
                $exception->getLine(),
                $exception->getTraceAsString()
            ));
        }
    }

    private function isProduction(): bool {
        return $this->config['app']['env'] ?? 'production' === 'production';
    }

    public static function register($config = null, $logger = null): void {
        $handler = new self($config, $logger);
        
        set_exception_handler([$handler, 'handle']);
        set_error_handler([$handler, 'handleError']);
        register_shutdown_function([$handler, 'handleShutdown']);
    }

    public function handleError(int $level, string $message, string $file = '', int $line = 0): void {
        if (error_reporting() & $level) {
            throw new \ErrorException($message, 0, $level, $file, $line);
        }
    }

    public function handleShutdown(): void {
        $error = error_get_last();
        if ($error && in_array($error['type'], [E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_PARSE])) {
            $this->handle(new \ErrorException(
                $error['message'],
                0,
                $error['type'],
                $error['file'],
                $error['line']
            ));
        }
    }
}
?>
