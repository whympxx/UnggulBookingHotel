<?php
/**
 * Hotel Entity
 * Core business entity representing a hotel
 * 
 * This entity encapsulates hotel business logic and validation rules
 */

namespace Entities\Hotel;

class Hotel {
    private $id;
    private $name;
    private $location;
    private $description;
    private $price;
    private $rating;
    private $image;
    private $facilities;
    private $agent_id;
    private $status;
    private $created_at;
    private $updated_at;

    // Hotel status constants
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_MAINTENANCE = 'maintenance';

    public function __construct(array $data = []) {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'] ?? '';
        $this->location = $data['location'] ?? '';
        $this->description = $data['description'] ?? '';
        $this->price = $data['price'] ?? 0;
        $this->rating = $data['rating'] ?? 0.0;
        $this->image = $data['image'] ?? '';
        $this->facilities = $data['facilities'] ?? [];
        $this->agent_id = $data['agent_id'] ?? null;
        $this->status = $data['status'] ?? self::STATUS_ACTIVE;
        $this->created_at = $data['created_at'] ?? null;
        $this->updated_at = $data['updated_at'] ?? null;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getLocation() { return $this->location; }
    public function getDescription() { return $this->description; }
    public function getPrice() { return $this->price; }
    public function getRating() { return $this->rating; }
    public function getImage() { return $this->image; }
    public function getFacilities() { return $this->facilities; }
    public function getAgentId() { return $this->agent_id; }
    public function getStatus() { return $this->status; }
    public function getCreatedAt() { return $this->created_at; }
    public function getUpdatedAt() { return $this->updated_at; }

    // Setters with validation
    public function setName(string $name): self {
        if (strlen(trim($name)) < 3) {
            throw new \InvalidArgumentException('Hotel name must be at least 3 characters long');
        }
        $this->name = trim($name);
        return $this;
    }

    public function setLocation(string $location): self {
        if (empty(trim($location))) {
            throw new \InvalidArgumentException('Hotel location cannot be empty');
        }
        $this->location = trim($location);
        return $this;
    }

    public function setDescription(string $description): self {
        $this->description = trim($description);
        return $this;
    }

    public function setPrice(float $price): self {
        if ($price < 0) {
            throw new \InvalidArgumentException('Hotel price cannot be negative');
        }
        $this->price = $price;
        return $this;
    }

    public function setRating(float $rating): self {
        if ($rating < 0 || $rating > 5) {
            throw new \InvalidArgumentException('Hotel rating must be between 0 and 5');
        }
        $this->rating = round($rating, 1);
        return $this;
    }

    public function setImage(string $image): self {
        $this->image = $image;
        return $this;
    }

    public function setFacilities(array $facilities): self {
        $this->facilities = array_filter($facilities, function($facility) {
            return !empty(trim($facility));
        });
        return $this;
    }

    public function setAgentId(?int $agent_id): self {
        $this->agent_id = $agent_id;
        return $this;
    }

    public function setStatus(string $status): self {
        $validStatuses = [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_MAINTENANCE];
        if (!in_array($status, $validStatuses)) {
            throw new \InvalidArgumentException('Invalid hotel status');
        }
        $this->status = $status;
        return $this;
    }

    // Business logic methods
    public function isActive(): bool {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function isAvailable(): bool {
        return $this->isActive() && !empty($this->name) && !empty($this->location);
    }

    public function addFacility(string $facility): self {
        $facility = trim($facility);
        if (!empty($facility) && !in_array($facility, $this->facilities)) {
            $this->facilities[] = $facility;
        }
        return $this;
    }

    public function removeFacility(string $facility): self {
        $this->facilities = array_filter($this->facilities, function($f) use ($facility) {
            return $f !== $facility;
        });
        $this->facilities = array_values($this->facilities); // Re-index array
        return $this;
    }

    public function hasFacility(string $facility): bool {
        return in_array($facility, $this->facilities);
    }

    public function getFormattedPrice(): string {
        return 'Rp. ' . number_format($this->price, 0, ',', '.');
    }

    public function getStarRating(): string {
        $fullStars = floor($this->rating);
        $halfStar = ($this->rating - $fullStars) >= 0.5 ? 1 : 0;
        $emptyStars = 5 - $fullStars - $halfStar;

        return str_repeat('★', $fullStars) . 
               str_repeat('☆', $halfStar) . 
               str_repeat('☆', $emptyStars);
    }

    public function getImageUrl(string $baseUrl = '/images/'): string {
        return $baseUrl . $this->image;
    }

    public function matchesSearch(string $query): bool {
        $query = strtolower(trim($query));
        if (empty($query)) {
            return true;
        }

        return strpos(strtolower($this->name), $query) !== false ||
               strpos(strtolower($this->location), $query) !== false ||
               strpos(strtolower($this->description), $query) !== false;
    }

    public function matchesLocation(string $location): bool {
        if (empty(trim($location)) || strtolower($location) === 'all') {
            return true;
        }

        return strpos(strtolower($this->location), strtolower($location)) !== false;
    }

    public function matchesPriceRange(?float $minPrice, ?float $maxPrice): bool {
        if ($minPrice !== null && $this->price < $minPrice) {
            return false;
        }
        if ($maxPrice !== null && $this->price > $maxPrice) {
            return false;
        }
        return true;
    }

    public function matchesRating(float $minRating): bool {
        return $this->rating >= $minRating;
    }

    // Validation methods
    public function validate(): array {
        $errors = [];

        if (strlen(trim($this->name)) < 3) {
            $errors[] = 'Hotel name must be at least 3 characters long';
        }

        if (empty(trim($this->location))) {
            $errors[] = 'Hotel location is required';
        }

        if ($this->price < 0) {
            $errors[] = 'Hotel price cannot be negative';
        }

        if ($this->rating < 0 || $this->rating > 5) {
            $errors[] = 'Hotel rating must be between 0 and 5';
        }

        return $errors;
    }

    public function isValid(): bool {
        return empty($this->validate());
    }

    // Array conversion methods
    public function toArray(): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'location' => $this->location,
            'description' => $this->description,
            'price' => $this->price,
            'rating' => $this->rating,
            'image' => $this->image,
            'facilities' => $this->facilities,
            'agent_id' => $this->agent_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function toPublicArray(): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'location' => $this->location,
            'description' => $this->description,
            'price' => $this->price,
            'formatted_price' => $this->getFormattedPrice(),
            'rating' => $this->rating,
            'star_rating' => $this->getStarRating(),
            'image' => $this->image,
            'image_url' => $this->getImageUrl(),
            'facilities' => $this->facilities,
            'status' => $this->status,
            'is_available' => $this->isAvailable(),
        ];
    }

    public function jsonSerialize(): array {
        return $this->toPublicArray();
    }

    public function __toString(): string {
        return $this->name . ' - ' . $this->location;
    }

    // Static factory methods
    public static function create(array $data): self {
        $hotel = new self($data);
        $hotel->created_at = date('Y-m-d H:i:s');
        return $hotel;
    }

    public static function getValidStatuses(): array {
        return [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_MAINTENANCE];
    }
}
?>
