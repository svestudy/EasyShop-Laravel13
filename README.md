# EasyShop - Laravel 13

A modern e-commerce platform built with **Laravel 13**, **Filament**, and **Livewire**.

## Features

✨ **Core Features:**
- User authentication and authorization
- Product catalog with categories and properties
- Shopping cart management with Livewire
- Order management system
- Wishlist functionality
- Product reviews and ratings
- User profile and address management

🛠️ **Admin Features (Filament):**
- Product management
- Category management
- Order management and tracking
- User management
- Dashboard with statistics
- Role-based access control

## Tech Stack

- **Backend:** Laravel 13
- **Frontend:** Livewire 3 + Blade
- **Admin Panel:** Filament 3
- **Database:** MySQL
- **Image Processing:** Intervention Image 3
- **Payment:** Stripe integration
- **Testing:** Pest PHP

## Installation

### Prerequisites
- PHP 8.2+
- Composer
- MySQL 8.0+
- Node.js 18+ (for assets)

### Steps

1. **Clone the repository:**
```bash
git clone https://github.com/svestudy/EasyShop-Laravel13.git
cd EasyShop-Laravel13
```

2. **Install dependencies:**
```bash
composer install
npm install
```

3. **Setup environment:**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configure database:**
```bash
# Edit .env with your database credentials
php artisan migrate
php artisan db:seed
```

5. **Build assets:**
```bash
npm run dev
```

6. **Create Filament admin user:**
```bash
php artisan filament:user
```

7. **Start development server:**
```bash
php artisan serve
```

Access the application at `http://localhost:8000` and admin panel at `http://localhost:8000/admin`

## Project Structure

```
app/
├── Models/          # Eloquent models
├── Http/
│   ├── Controllers/ # Web controllers
│   └── Livewire/   # Livewire components
├── Filament/
│   ├── Resources/  # Filament resources
│   └── Widgets/    # Dashboard widgets
└── Services/       # Business logic

database/
├── migrations/     # Database migrations
├── seeders/       # Database seeders
└── factories/     # Model factories

resources/
├── views/
│   ├── layouts/   # Layout templates
│   └── livewire/  # Livewire view files
└── css/          # Stylesheets

routes/
├── web.php        # Web routes
└── api.php        # API routes
```

## Database Schema

### Core Tables:
- `users` - Customer and admin accounts
- `products` - Product information
- `categories` - Product categories
- `product_properties` - Product attributes (size, color, etc.)
- `orders` - Order records
- `order_items` - Items in orders
- `wishlists` - User wishlists
- `reviews` - Product reviews
- `addresses` - Delivery addresses

## API Endpoints

```
GET    /api/products           - List all products
GET    /api/products/{id}      - Get product details
GET    /api/categories         - List categories
POST   /api/cart/add           - Add to cart
DELETE /api/cart/{id}          - Remove from cart
POST   /api/orders             - Create order
```

## Filament Resources

- **ProductResource** - Manage products
- **CategoryResource** - Manage categories
- **OrderResource** - View and manage orders
- **UserResource** - User management

## Livewire Components

- `ProductCard` - Product display component
- `CartComponent` - Shopping cart
- `CheckoutForm` - Checkout process
- `WishlistComponent` - Wishlist management
- `ProductFilter` - Product filtering

## Configuration

### Stripe Setup
Add your Stripe keys to `.env`:
```
STRIPE_PUBLIC_KEY=pk_test_...
STRIPE_SECRET_KEY=sk_test_...
```

### File Storage
Configure file storage in `config/filesystems.php`

## Testing

```bash
# Run all tests
npm run test

# Run specific test
npm run test -- tests/Feature/ProductTest.php
```

## Development

```bash
# Format code
npm run lint

# Tinker shell
php artisan tinker
```

## Deployment

1. Set `APP_ENV=production` and `APP_DEBUG=false` in `.env`
2. Run migrations: `php artisan migrate --force`
3. Cache configuration: `php artisan config:cache`
4. Cache routes: `php artisan route:cache`
5. Optimize: `php artisan optimize`

## Troubleshooting

**Database connection error:**
- Verify MySQL is running
- Check `.env` database credentials

**Livewire not updating:**
- Clear cache: `php artisan cache:clear`
- Rebuild assets: `npm run dev`

**Filament not loading:**
- Publish assets: `php artisan filament:publish`
- Clear cache: `php artisan cache:clear`

## License

MIT License - see LICENSE file for details

## Support

For issues and questions, please create an issue on GitHub.
