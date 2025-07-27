# Feature-Sliced Design (FSD) Architecture

## 🏗️ Struktur Proyek dengan FSD

Proyek ini telah direstrukturisasi menggunakan metodologi **Feature-Sliced Design (FSD)** untuk meningkatkan maintainability, scalability, dan organization dari kodebase.

## 📁 Struktur Direktori

```
src/
├── app/                    # 🎯 Application Layer
│   ├── index.php          # Main entry point
│   └── providers/         # App-level providers
│       ├── routing.php    # Routing logic
│       ├── database.php   # Database connection
│       └── auth.php       # Authentication provider
│
├── shared/                # 🔄 Shared Layer
│   ├── ui/               # Shared UI components
│   │   └── components/
│   │       └── header.php # Header component
│   └── lib/              # Shared utilities
│       └── utils.php     # Common utility functions
│
├── features/             # ✨ Features Layer
│   ├── hotel-booking/    # Hotel booking feature
│   │   ├── model/        # Business logic & data
│   │   │   └── hotel.php
│   │   ├── view/         # UI templates
│   │   │   └── hotels.php
│   │   └── routes.php    # Route definitions
│   │
│   ├── user-management/  # User management feature
│   ├── admin-dashboard/  # Admin dashboard feature
│   ├── agent-management/ # Agent management feature
│   └── payment-processing/ # Payment processing feature
│
└── entities/             # 📊 Entities Layer (Data Models)
    ├── hotel/
    ├── user/
    ├── booking/
    └── payment/
```

## 🎨 Layer Descriptions

### 🎯 App Layer (`src/app/`)
- **Purpose**: Application initialization and configuration
- **Contains**: 
  - Main entry point
  - Global providers (routing, database, auth)
  - Application-level configuration

### ✨ Features Layer (`src/features/`)
- **Purpose**: Business features organized by domain
- **Structure**: Each feature contains:
  - `model/` - Business logic and data operations
  - `view/` - UI templates specific to the feature
  - `routes.php` - Route definitions for the feature

### 🔄 Shared Layer (`src/shared/`)
- **Purpose**: Reusable components and utilities
- **Contains**:
  - `ui/components/` - Shared UI components
  - `lib/` - Utility functions and helpers

### 📊 Entities Layer (`src/entities/`)
- **Purpose**: Business entities and data models
- **Contains**: Core business logic that represents domain objects

## 🚀 Implemented Features

### ✅ Hotel Booking Feature
**Location**: `src/features/hotel-booking/`

**Components**:
- **Model** (`model/hotel.php`):
  - Hotel data operations
  - Search and filtering
  - Favorites management
  - Room availability checking

- **View** (`view/hotels.php`):
  - Hotel listing interface
  - Search and filter UI
  - Responsive design
  - Interactive features

- **Routes** (`routes.php`):
  - `/` - Hotel listing
  - `/hotels` - Filtered hotel search
  - `/hotel/{id}` - Hotel details
  - `/hotel/{id}/favorite` - Add to favorites
  - `/hotel/{id}/unfavorite` - Remove from favorites

## 🔧 Key Components

### 🗂️ Router Provider (`src/app/providers/routing.php`)
- Handles application routing
- Supports GET and POST methods
- URL parameter extraction
- 404 error handling

### 💾 Database Provider (`src/app/providers/database.php`)
- PDO-based database operations
- CRUD operations wrapper
- Error handling
- Connection management

### 🔐 Authentication Provider (`src/app/providers/auth.php`)
- User authentication and authorization
- Session management
- Role-based access control
- CSRF protection

### 🛠️ Utilities (`src/shared/lib/utils.php`)
- Input sanitization
- Currency formatting
- File upload handling
- Logging functionality
- JSON responses
- Flash messages
- Pagination helpers

## 🌟 Benefits of FSD Architecture

### 1. **Modularitas**
- Setiap fitur terisolasi dan independen
- Mudah untuk mengembangkan fitur baru
- Mengurangi coupling antar komponen

### 2. **Maintainability**
- Kode terorganisir berdasarkan domain bisnis
- Mudah mencari dan memahami kode
- Refactoring lebih aman

### 3. **Scalability**
- Mudah menambah developer baru ke tim
- Fitur dapat dikembangkan secara paralel
- Deployment dapat dilakukan per fitur

### 4. **Testability**
- Setiap layer dapat ditest secara independen
- Mock dependencies lebih mudah
- Unit testing lebih efektif

## 🚀 Development Workflow

### Menambah Fitur Baru

1. **Buat direktori fitur baru**:
   ```
   src/features/new-feature/
   ├── model/
   ├── view/
   └── routes.php
   ```

2. **Implementasi model** (business logic)
3. **Buat view** (UI templates)
4. **Define routes** (URL endpoints)
5. **Register routes** di `src/app/index.php`

### Menambah Shared Component

1. **Buat component** di `src/shared/ui/components/`
2. **Export function** yang dapat digunakan di features
3. **Update documentation**

## 📝 Migration from Legacy Structure

### Files Moved/Restructured:
- ✅ `index.php` → Refactored with FSD structure
- ✅ Hotel logic → `src/features/hotel-booking/`
- ✅ Shared components → `src/shared/ui/components/`
- ✅ Utilities → `src/shared/lib/utils.php`

### Legacy Files (Still Active):
- Original files remain for backward compatibility
- Gradual migration approach
- Features will be migrated incrementally

## 🔄 Next Steps

### Planned Features:
1. **User Management** (`src/features/user-management/`)
   - Registration, login, profile management
   
2. **Admin Dashboard** (`src/features/admin-dashboard/`)
   - Statistics, hotel management, user management
   
3. **Agent Management** (`src/features/agent-management/`)
   - Agent dashboard, property management
   
4. **Payment Processing** (`src/features/payment-processing/`)
   - Payment gateway integration, transaction management

### Technical Improvements:
1. **Database Integration**
   - Replace mock data with actual database operations
   - Implement proper migrations
   
2. **API Layer**
   - RESTful API endpoints
   - JSON responses for AJAX requests
   
3. **Testing Framework**
   - Unit tests for models
   - Integration tests for features
   
4. **Build Process**
   - Asset compilation
   - CSS/JS optimization

## 🎯 Usage Examples

### Using Hotel Model:
```php
// Get all hotels with filters
$hotelModel = new HotelModel();
$hotels = $hotelModel->getAllHotels([
    'location' => 'Jakarta',
    'min_price' => 500000
]);

// Get hotel details
$hotel = $hotelModel->getHotelById(1);
```

### Using Utilities:
```php
// Format currency
$formatted = Utils::formatCurrency(1500000); // "Rp. 1.500.000"

// Sanitize input
$clean = Utils::sanitize($_POST['data']);

// JSON response
Utils::jsonResponse(['status' => 'success', 'data' => $hotels]);
```

### Using Authentication:
```php
$auth = new AuthProvider();

// Check if user is logged in
if ($auth->isLoggedIn()) {
    $user = $auth->getCurrentUser();
}

// Require authentication
$auth->requireAuth();

// Require specific role
$auth->requireRole('admin');
```

## 📚 Resources

- [Feature-Sliced Design Documentation](https://feature-sliced.design/)
- [PHP Best Practices](https://www.php-fig.org/psr/)
- [Clean Architecture Principles](https://blog.cleancoder.com/uncle-bob/2012/08/13/the-clean-architecture.html)

---

**Made with ❤️ following FSD methodology**
