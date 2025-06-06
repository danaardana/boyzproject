# Products System Documentation

## Overview

This system provides a flexible product structure that allows products to have multiple configurable options with availability tracking. It's designed to handle real-world scenarios like:

- **Mounting & Body products** with different motor types and sizes
- **Lampu (Lamp) products** with quantity options
- Any product that needs multiple selectable options with availability status

## Database Structure

The system consists of three related tables:

### 1. `products` Table
Stores the main product information:
- `id` - Primary key
- `name` - Product name (e.g., "Mounting Upsize All", "Turbo SE Experience 60W")
- `category` - Product category (e.g., "Mounting & Body", "Lampu")
- `image` - Product image filename (nullable)
- `description` - Product description (nullable)
- `stock` - Available stock quantity
- `sold` - Number of units sold
- `ratings` - Number of ratings received
- `average_rating` - Average rating (0.0 to 5.0)
- `is_active` - Whether the product is active/available
- `created_at`, `updated_at` - Timestamps

### 2. `product_options` Table
Stores option types for each product:
- `id` - Primary key
- `product_id` - Foreign key to products table
- `option_name` - Internal option name (e.g., "motor_type", "size", "quantity")
- `display_name` - User-friendly option name (e.g., "Motor Type", "Size", "Quantity")
- `is_required` - Whether this option must be selected
- `sort_order` - Display order of options
- `created_at`, `updated_at` - Timestamps

### 3. `product_option_values` Table
Stores the actual values for each option:
- `id` - Primary key
- `product_option_id` - Foreign key to product_options table
- `value` - Internal value (e.g., "aerox_old", "3cm", "single")
- `display_value` - User-friendly value (e.g., "Aerox Old", "3cm", "Single")
- `price_adjustment` - Price adjustment for this option (can be positive or negative)
- `is_default` - Whether this is the default selection
- `is_available` - **NEW: Binary status indicating if this option is available**
- `sort_order` - Display order of values
- `created_at`, `updated_at` - Timestamps

## Current Dataset

### 1. Mounting Upsize All
- **Category**: Mounting & Body
- **Stock**: 3,901 units
- **Sold**: 377
- **Ratings**: 192
- **Average Rating**: 4.6 stars

**Options:**
```
Motor Type (required):
├── Aerox Old (available)
├── Aerox New (available)
├── Aerox Alpha (available)
├── Nmax New (available)
├── Nmax Neo (available)
└── Lexy (UNAVAILABLE)

Size (required):
├── 3cm to 9cm (all available)
```

### 2. Mounting Vario
- **Category**: Mounting & Body
- **Stock**: 3,006 units
- **Sold**: 3,100
- **Ratings**: 1,600
- **Average Rating**: 4.8 stars

**Options:**
```
Motor Type (required):
├── Vario LED Old (available)
├── Vario LED New (available)
├── Beat ESP (available)
└── Scoopy ESP (available)

Size (required):
├── 3cm to 9cm (all available)
```

### 3. Turbo SE Experience 60W
- **Category**: Lampu
- **Stock**: 90 units
- **Sold**: 0
- **Ratings**: 0
- **Average Rating**: 0.0 stars

**Options:**
```
Quantity (required):
├── Single (+$0.00)
└── Pair (+$20.00)
```

## Model Relationships

### Product Model
- `hasMany(ProductOption::class)` - A product can have multiple options
- `getAllOptionValues()` - Helper method to get all option values for the product

### ProductOption Model
- `belongsTo(Product::class)` - Each option belongs to a product
- `hasMany(ProductOptionValue::class)` - Each option can have multiple values
- `availableValues()` - Get only available option values

### ProductOptionValue Model
- `belongsTo(ProductOption::class)` - Each value belongs to an option
- `scopeAvailable()` - Scope to filter only available values
- `getFormattedPriceAdjustmentAttribute()` - Helper to format price adjustments

## Usage Examples

### 1. Get All Products with Available Options Only
```php
$products = Product::active()
    ->with(['productOptions.availableValues'])
    ->get();
```

### 2. Get All Products Including Unavailable Options
```php
$products = Product::active()
    ->with(['productOptions.productOptionValues'])
    ->get();
```

### 3. Get Available Option Values Only
```php
$availableValues = ProductOptionValue::available()
    ->where('product_option_id', $optionId)
    ->get();
```

### 4. Filter Products by Category
```php
$mountingProducts = Product::active()
    ->where('category', 'Mounting & Body')
    ->with(['productOptions.availableValues'])
    ->get();
```

### 5. Check Stock and Sales Performance
```php
$product = Product::find(1);
echo "Stock: " . $product->stock;
echo "Sold: " . $product->sold;
echo "Rating: " . $product->average_rating . " (" . $product->ratings . " reviews)";
```

## API Endpoints (ProductController)

### Basic Endpoints
- `GET /products` - List all active products with available options
- `GET /products?show_unavailable=true` - Include unavailable options
- `GET /products/{id}` - Get specific product with available options
- `GET /products/{id}?show_unavailable=true` - Include unavailable options
- `GET /products/{id}/options` - Get options for a specific product
- `POST /products/{id}/calculate-price` - Calculate price with selected options
- `POST /products` - Create new product with options

### New Parameters
- `show_unavailable` - Boolean parameter to include unavailable option values in response

## Availability System

### Key Features
1. **Binary Status**: Each option value has an `is_available` boolean field
2. **Filtering**: API can filter to show only available options by default
3. **Flexibility**: Admin can still view all options including unavailable ones
4. **Real-time**: Availability can be updated without affecting the option structure

### Example: Lexy Motor Type
The "Lexy" motor type in "Mounting Upsize All" is marked as unavailable (`is_available = false`), so it won't appear in normal API responses unless specifically requested.

## Running the Updated System

1. **Run Migrations:**
   ```bash
   php artisan migrate
   ```

2. **Seed with New Dataset:**
   ```bash
   php artisan db:seed --class=ProductSeeder
   ```

3. **Test the API:**
   ```bash
   # Get products with available options only
   GET /products
   
   # Get products including unavailable options
   GET /products?show_unavailable=true
   ```

## Key Improvements

1. **Real Dataset**: Now using actual product data from your inventory
2. **Stock Management**: Track stock levels and sales
3. **Rating System**: Support for customer ratings and reviews
4. **Availability Control**: Binary status for each option value
5. **Category Organization**: Products organized by categories
6. **Flexible API**: Option to show/hide unavailable items
7. **Performance Tracking**: Sales and rating analytics

This structure provides a robust foundation for managing real-world product catalogs with dynamic availability and comprehensive product information. 