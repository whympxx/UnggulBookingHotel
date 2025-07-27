<?php
/**
 * User Entity
 * Core business entity representing a user
 * 
 * This entity encapsulates user business logic and validation rules
 */

namespace Entities\User;

class User {
    private $id;
    private $name;
    private $email;
    private $password;
    private $role;
    private $phone;
    private $avatar;
    private $email_verified_at;
    private $status;
    private $created_at;
    private $updated_at;

    // User role constants
    const ROLE_USER = 'user';
    const ROLE_AGENT = 'agent';
    const ROLE_ADMIN = 'admin';

    // User status constants
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_SUSPENDED = 'suspended';

    public function __construct(array $data = []) {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'] ?? '';
        $this->email = $data['email'] ?? '';
        $this->password = $data['password'] ?? '';
        $this->role = $data['role'] ?? self::ROLE_USER;
        $this->phone = $data['phone'] ?? '';
        $this->avatar = $data['avatar'] ?? '';
        $this->email_verified_at = $data['email_verified_at'] ?? null;
        $this->status = $data['status'] ?? self::STATUS_ACTIVE;
        $this->created_at = $data['created_at'] ?? null;
        $this->updated_at = $data['updated_at'] ?? null;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getEmail() { return $this->email; }
    public function getPassword() { return $this->password; }
    public function getRole() { return $this->role; }
    public function getPhone() { return $this->phone; }
    public function getAvatar() { return $this->avatar; }
    public function getEmailVerifiedAt() { return $this->email_verified_at; }
    public function getStatus() { return $this->status; }
    public function getCreatedAt() { return $this->created_at; }
    public function getUpdatedAt() { return $this->updated_at; }

    // Setters with validation
    public function setName(string $name): self {
        if (strlen(trim($name)) < 2) {
            throw new \InvalidArgumentException('Name must be at least 2 characters long');
        }
        $this->name = trim($name);
        return $this;
    }

    public function setEmail(string $email): self {
        $email = trim(strtolower($email));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Invalid email format');
        }
        $this->email = $email;
        return $this;
    }

    public function setPassword(string $password): self {
        if (strlen($password) < 8) {
            throw new \InvalidArgumentException('Password must be at least 8 characters long');
        }
        // Don't hash here - let the service layer handle it
        $this->password = $password;
        return $this;
    }

    public function setHashedPassword(string $hashedPassword): self {
        $this->password = $hashedPassword;
        return $this;
    }

    public function setRole(string $role): self {
        $validRoles = [self::ROLE_USER, self::ROLE_AGENT, self::ROLE_ADMIN];
        if (!in_array($role, $validRoles)) {
            throw new \InvalidArgumentException('Invalid user role');
        }
        $this->role = $role;
        return $this;
    }

    public function setPhone(?string $phone): self {
        if ($phone !== null) {
            $phone = preg_replace('/[^0-9+]/', '', $phone);
            if (!empty($phone) && strlen($phone) < 10) {
                throw new \InvalidArgumentException('Phone number must be at least 10 digits');
            }
        }
        $this->phone = $phone;
        return $this;
    }

    public function setAvatar(?string $avatar): self {
        $this->avatar = $avatar;
        return $this;
    }

    public function setStatus(string $status): self {
        $validStatuses = [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_SUSPENDED];
        if (!in_array($status, $validStatuses)) {
            throw new \InvalidArgumentException('Invalid user status');
        }
        $this->status = $status;
        return $this;
    }

    // Business logic methods
    public function isActive(): bool {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function isAdmin(): bool {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isAgent(): bool {
        return $this->role === self::ROLE_AGENT;
    }

    public function isUser(): bool {
        return $this->role === self::ROLE_USER;
    }

    public function hasRole(string $role): bool {
        return $this->role === $role;
    }

    public function hasAnyRole(array $roles): bool {
        return in_array($this->role, $roles);
    }

    public function isEmailVerified(): bool {
        return !empty($this->email_verified_at);
    }

    public function markEmailAsVerified(): self {
        $this->email_verified_at = date('Y-m-d H:i:s');
        return $this;
    }

    public function canManageHotels(): bool {
        return $this->isAgent() || $this->isAdmin();
    }

    public function canAccessAdminPanel(): bool {
        return $this->isAdmin();
    }

    public function canBookHotels(): bool {
        return $this->isActive() && ($this->isUser() || $this->isAgent() || $this->isAdmin());
    }

    public function getDisplayName(): string {
        return $this->name ?: $this->email;
    }

    public function getInitials(): string {
        $words = explode(' ', trim($this->name));
        $initials = '';
        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= strtoupper($word[0]);
            }
        }
        return substr($initials, 0, 2);
    }

    public function getAvatarUrl(string $baseUrl = '/images/avatars/'): string {
        if (!empty($this->avatar)) {
            return $baseUrl . $this->avatar;
        }
        
        // Generate default avatar based on initials
        return $this->generateDefaultAvatar();
    }

    public function generateDefaultAvatar(): string {
        // Simple default avatar generation
        $initials = $this->getInitials();
        $colors = ['#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFEAA7', '#DDA0DD', '#98D8C8'];
        $colorIndex = ord($this->email[0]) % count($colors);
        $color = $colors[$colorIndex];
        
        return "https://ui-avatars.com/api/?name={$initials}&background=" . substr($color, 1) . "&color=fff&size=100";
    }

    public function getFormattedPhone(): string {
        if (empty($this->phone)) {
            return '';
        }
        
        // Format Indonesian phone numbers
        $phone = preg_replace('/[^0-9]/', '', $this->phone);
        if (strlen($phone) >= 10) {
            return preg_replace('/(\d{4})(\d{4})(\d+)/', '$1-$2-$3', $phone);
        }
        
        return $phone;
    }

    public function getJoinDate(): string {
        if (empty($this->created_at)) {
            return '';
        }
        
        return date('F Y', strtotime($this->created_at));
    }

    // Password verification
    public function verifyPassword(string $password): bool {
        return password_verify($password, $this->password);
    }

    // Validation methods
    public function validate(): array {
        $errors = [];

        if (strlen(trim($this->name)) < 2) {
            $errors[] = 'Name must be at least 2 characters long';
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email format';
        }

        if (empty($this->password)) {
            $errors[] = 'Password is required';
        } elseif (strlen($this->password) < 8 && !password_get_info($this->password)['algo']) {
            // Only validate length if it's not already hashed
            $errors[] = 'Password must be at least 8 characters long';
        }

        if (!empty($this->phone) && strlen(preg_replace('/[^0-9]/', '', $this->phone)) < 10) {
            $errors[] = 'Phone number must be at least 10 digits';
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
            'email' => $this->email,
            'password' => $this->password,
            'role' => $this->role,
            'phone' => $this->phone,
            'avatar' => $this->avatar,
            'email_verified_at' => $this->email_verified_at,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function toPublicArray(): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'phone' => $this->phone,
            'formatted_phone' => $this->getFormattedPhone(),
            'avatar' => $this->avatar,
            'avatar_url' => $this->getAvatarUrl(),
            'initials' => $this->getInitials(),
            'display_name' => $this->getDisplayName(),
            'email_verified' => $this->isEmailVerified(),
            'status' => $this->status,
            'is_active' => $this->isActive(),
            'join_date' => $this->getJoinDate(),
            'permissions' => [
                'can_manage_hotels' => $this->canManageHotels(),
                'can_access_admin' => $this->canAccessAdminPanel(),
                'can_book_hotels' => $this->canBookHotels(),
            ]
        ];
    }

    public function toSecureArray(): array {
        $data = $this->toPublicArray();
        unset($data['email']); // Remove email from secure context
        return $data;
    }

    public function jsonSerialize(): array {
        return $this->toPublicArray();
    }

    public function __toString(): string {
        return $this->getDisplayName() . ' (' . $this->email . ')';
    }

    // Static factory methods
    public static function create(array $data): self {
        $user = new self($data);
        $user->created_at = date('Y-m-d H:i:s');
        return $user;
    }

    public static function getValidRoles(): array {
        return [self::ROLE_USER, self::ROLE_AGENT, self::ROLE_ADMIN];
    }

    public static function getValidStatuses(): array {
        return [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_SUSPENDED];
    }

    public static function getRoleDisplayNames(): array {
        return [
            self::ROLE_USER => 'User',
            self::ROLE_AGENT => 'Agent',
            self::ROLE_ADMIN => 'Administrator',
        ];
    }
}
?>
