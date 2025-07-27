<?php
/**
 * Simple Test Runner for FSD Architecture
 * Basic testing framework implementation
 */

class TestRunner {
    private $tests = [];
    private $passed = 0;
    private $failed = 0;
    private $errors = [];

    public function addTest(callable $test, string $name): void {
        $this->tests[] = ['callable' => $test, 'name' => $name];
    }

    public function run(): void {
        echo "🧪 Running FSD Architecture Tests...\n";
        echo str_repeat("=", 50) . "\n";

        foreach ($this->tests as $test) {
            $this->runSingleTest($test['callable'], $test['name']);
        }

        $this->printSummary();
    }

    private function runSingleTest(callable $test, string $name): void {
        try {
            echo "Testing: {$name} ... ";
            $result = $test();
            
            if ($result === true || $result === null) {
                echo "✅ PASSED\n";
                $this->passed++;
            } else {
                echo "❌ FAILED\n";
                $this->failed++;
                $this->errors[] = "{$name}: Test returned false";
            }
        } catch (Exception $e) {
            echo "❌ ERROR\n";
            $this->failed++;
            $this->errors[] = "{$name}: " . $e->getMessage();
        }
    }

    private function printSummary(): void {
        echo str_repeat("=", 50) . "\n";
        echo "📊 Test Summary:\n";
        echo "✅ Passed: {$this->passed}\n";
        echo "❌ Failed: {$this->failed}\n";
        echo "📋 Total: " . ($this->passed + $this->failed) . "\n";

        if (!empty($this->errors)) {
            echo "\n🚨 Errors:\n";
            foreach ($this->errors as $error) {
                echo "  - {$error}\n";
            }
        }

        if ($this->failed === 0) {
            echo "\n🎉 All tests passed!\n";
        }
    }
}

// Test Helper Functions
function assertEquals($expected, $actual, $message = '') {
    if ($expected !== $actual) {
        $msg = $message ?: "Expected: " . var_export($expected, true) . ", Got: " . var_export($actual, true);
        throw new Exception($msg);
    }
}

function assertTrue($condition, $message = 'Assertion failed') {
    if (!$condition) {
        throw new Exception($message);
    }
}

function assertFalse($condition, $message = 'Assertion failed') {
    if ($condition) {
        throw new Exception($message);
    }
}

function assertNotNull($value, $message = 'Value should not be null') {
    if ($value === null) {
        throw new Exception($message);
    }
}

function assertInstanceOf($expectedClass, $actual, $message = '') {
    if (!($actual instanceof $expectedClass)) {
        $actualClass = get_class($actual);
        $msg = $message ?: "Expected instance of {$expectedClass}, got {$actualClass}";
        throw new Exception($msg);
    }
}

// Auto-include required files for testing
$baseDir = __DIR__ . '/../src';

// Include entities
require_once $baseDir . '/entities/hotel/Hotel.php';
require_once $baseDir . '/entities/user/User.php';

// Include app components
require_once $baseDir . '/app/providers/database.php';
require_once $baseDir . '/app/providers/auth.php';
require_once $baseDir . '/shared/lib/utils.php';

// Run Tests
$runner = new TestRunner();

// Test Hotel Entity
$runner->addTest(function() {
    $hotel = new \Entities\Hotel\Hotel([
        'name' => 'Test Hotel',
        'location' => 'Jakarta',
        'price' => 500000,
        'rating' => 4.5
    ]);

    assertEquals('Test Hotel', $hotel->getName());
    assertEquals('Jakarta', $hotel->getLocation());
    assertEquals(500000, $hotel->getPrice());
    assertEquals(4.5, $hotel->getRating());
    assertTrue($hotel->isActive());
    assertTrue($hotel->isAvailable());
    
    return true;
}, 'Hotel Entity Creation');

$runner->addTest(function() {
    $hotel = new \Entities\Hotel\Hotel();
    $hotel->setName('Updated Hotel')
          ->setLocation('Bandung')
          ->setPrice(750000)
          ->setRating(4.8);

    assertEquals('Updated Hotel', $hotel->getName());
    assertEquals('Bandung', $hotel->getLocation());
    assertEquals(750000, $hotel->getPrice());
    assertEquals(4.8, $hotel->getRating());
    
    return true;
}, 'Hotel Entity Setters');

$runner->addTest(function() {
    $hotel = new \Entities\Hotel\Hotel([
        'name' => 'Search Test Hotel',
        'location' => 'Jakarta Pusat',
        'description' => 'Luxury hotel in central Jakarta'
    ]);

    assertTrue($hotel->matchesSearch('Search Test'));
    assertTrue($hotel->matchesSearch('jakarta'));
    assertTrue($hotel->matchesSearch('luxury'));
    assertFalse($hotel->matchesSearch('bali'));
    
    assertTrue($hotel->matchesLocation('jakarta'));
    assertTrue($hotel->matchesLocation('pusat'));
    assertFalse($hotel->matchesLocation('bandung'));
    
    return true;
}, 'Hotel Entity Search Logic');

$runner->addTest(function() {
    $hotel = new \Entities\Hotel\Hotel([
        'name' => 'Facility Test Hotel',
        'facilities' => ['WiFi', 'Pool', 'Gym']
    ]);

    assertTrue($hotel->hasFacility('WiFi'));
    assertTrue($hotel->hasFacility('Pool'));
    assertFalse($hotel->hasFacility('Spa'));
    
    $hotel->addFacility('Spa');
    assertTrue($hotel->hasFacility('Spa'));
    
    $hotel->removeFacility('Gym');
    assertFalse($hotel->hasFacility('Gym'));
    
    return true;
}, 'Hotel Entity Facilities Management');

// Test User Entity
$runner->addTest(function() {
    $user = new \Entities\User\User([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'role' => 'user'
    ]);

    assertEquals('John Doe', $user->getName());
    assertEquals('john@example.com', $user->getEmail());
    assertEquals('user', $user->getRole());
    assertTrue($user->isUser());
    assertFalse($user->isAdmin());
    assertTrue($user->isActive());
    
    return true;
}, 'User Entity Creation');

$runner->addTest(function() {
    $user = new \Entities\User\User(['name' => 'Jane Smith']);
    
    $user->setEmail('jane@example.com')
         ->setRole('agent')
         ->setPhone('08123456789');

    assertEquals('jane@example.com', $user->getEmail());
    assertEquals('agent', $user->getRole());
    assertEquals('08123456789', $user->getPhone());
    assertTrue($user->isAgent());
    assertTrue($user->canManageHotels());
    
    return true;
}, 'User Entity Setters and Permissions');

$runner->addTest(function() {
    $user = new \Entities\User\User(['name' => 'Admin User', 'role' => 'admin']);
    
    assertTrue($user->isAdmin());
    assertTrue($user->canAccessAdminPanel());
    assertTrue($user->canManageHotels());
    assertTrue($user->canBookHotels());
    
    return true;
}, 'User Entity Admin Permissions');

// Test Utils Class
$runner->addTest(function() {
    $formatted = Utils::formatCurrency(1500000);
    assertEquals('Rp. 1.500.000', $formatted);
    
    $clean = Utils::sanitize('<script>alert("test")</script>Test Data');
    assertFalse(strpos($clean, '<script>') !== false);
    assertTrue(strpos($clean, 'Test Data') !== false);
    
    assertTrue(Utils::validateEmail('test@example.com'));
    assertFalse(Utils::validateEmail('invalid-email'));
    
    return true;
}, 'Utils Class Functions');

// Test Validation
$runner->addTest(function() {
    $hotel = new \Entities\Hotel\Hotel(['name' => 'Test']);
    $errors = $hotel->validate();
    assertTrue(empty($errors), 'Hotel with valid name should pass validation');
    
    $hotel = new \Entities\Hotel\Hotel(['name' => 'A']); // Too short
    $errors = $hotel->validate();
    assertFalse(empty($errors), 'Hotel with short name should fail validation');
    
    return true;
}, 'Entity Validation');

// Test Array Conversion
$runner->addTest(function() {
    $hotel = new \Entities\Hotel\Hotel([
        'id' => 1,
        'name' => 'Test Hotel',
        'price' => 500000
    ]);
    
    $array = $hotel->toArray();
    assertEquals(1, $array['id']);
    assertEquals('Test Hotel', $array['name']);
    assertEquals(500000, $array['price']);
    
    $publicArray = $hotel->toPublicArray();
    assertEquals('Rp. 500.000', $publicArray['formatted_price']);
    assertTrue(isset($publicArray['is_available']));
    
    return true;
}, 'Entity Array Conversion');

// Run all tests
$runner->run();
?>
