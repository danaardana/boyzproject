# Product System Documentation

## Overview

The Product System is a sophisticated e-commerce solution designed for motorcycle parts and accessories. It features a flexible option system that allows products to have multiple configurable attributes with availability tracking, perfect for handling real-world scenarios like different motor types, sizes, and quantities.

## Architecture

### Database Structure

The system uses a three-table relational structure:

#### 1. Products Table (`products`)
**Primary product information storage**

**Fields:**
- `id` - Primary key
- `name` - Product name (e.g., "Mounting Upsize All", "LED Headlight Kit")
- `category` - Product category (e.g., "Mounting & Body", "Lighting")
- `image` - Product image filename (nullable)
- `description` - Detailed product description (nullable, text field)
- `stock` - Available inventory quantity
- `sold` - Number of units sold (for analytics)
- `ratings` - Total number of ratings received
- `average_rating` - Calculated average rating (0.0 to 5.0)
- `is_active` - Product availability status (boolean)
- `created_at`, `updated_at` - Timestamp fields

#### 2. Product Options Table (`product_options`)
**Configurable option types for each product**

**Fields:**
- `id` - Primary key
- `product_id` - Foreign key reference to products table
- `option_name` - Internal identifier (e.g., "motor_type", "size", "quantity")
- `display_name` - User-friendly label (e.g., "Motor Type", "Size", "Quantity")
- `is_required` - Whether selection is mandatory (boolean)
- `sort_order` - Display order for options
- `created_at`, `updated_at` - Timestamp fields

#### 3. Product Option Values Table (`product_option_values`)
**Individual option choices with pricing and availability**

**Fields:**
- `id` - Primary key
- `product_option_id` - Foreign key to product_options table
- `value` - Internal value identifier (e.g., "aerox_old", "3cm", "single")
- `display_value` - Customer-facing label (e.g., "Aerox Old", "3cm", "Single")
- `price_adjustment` - Price modifier (decimal, can be positive/negative)
- `is_available` - Current availability status (boolean)
- `created_at`, `updated_at` - Timestamp fields

### Model Relationships

```php
// Product Model
class Product extends Model
{
    public function productOptions()
    {
        return $this->hasMany(ProductOption::class);
    }
    
    public function availableOptions()
    {
        return $this->productOptions()->with('availableValues');
    }
}

// ProductOption Model
class ProductOption extends Model
{
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    public function productOptionValues()
    {
        return $this->hasMany(ProductOptionValue::class);
    }
    
    public function availableValues()
    {
        return $this->productOptionValues()->where('is_available', true);
    }
}

// ProductOptionValue Model
class ProductOptionValue extends Model
{
    public function productOption()
    {
        return $this->belongsTo(ProductOption::class);
    }
}
```

## Product Categories

### Current Categories

#### 1. Mounting & Body
**Products for motorcycle structural modifications**
- Engine mounts
- Bracket systems
- Body modification parts
- Frame reinforcements

**Common Options:**
- Motor Type: Aerox Old, Aerox New, Nmax Old, Nmax New
- Size: Various dimensions (2cm, 3cm, 4cm, etc.)
- Material: Steel, Aluminum, Carbon Fiber

#### 2. Lighting (Lampu)
**Illumination and visibility products**
- LED headlight kits
- Turn signal lights
- Tail light assemblies
- Custom lighting solutions

**Common Options:**
- Quantity: Single, Pair, Set of 4
- Brightness: Standard, High, Ultra Bright
- Color: White, Yellow, RGB

#### 3. Installation Services
**Professional installation and maintenance**
- Product installation
- Custom modifications
- Maintenance services
- Consultation

**Common Options:**
- Service Type: Basic, Premium, Custom
- Duration: 1 hour, 2 hours, Half day
- Warranty: 6 months, 1 year, 2 years

## Option System

### Option Types

#### Required Options
Options marked as `is_required = true` must be selected before purchase.

```php
// Example: Motor type is required for mounting products
$motorTypeOption = ProductOption::create([
    'product_id' => $mountingProduct->id,
    'option_name' => 'motor_type',
    'display_name' => 'Motor Type',
    'is_required' => true,
    'sort_order' => 1
]);
```

#### Optional Options
Options marked as `is_required = false` provide additional customization.

```php
// Example: Warranty extension is optional
$warrantyOption = ProductOption::create([
    'product_id' => $product->id,
    'option_name' => 'warranty_extension',
    'display_name' => 'Extended Warranty',
    'is_required' => false,
    'sort_order' => 3
]);
```

### Pricing System

#### Base Price
Each product has an implicit base price (calculated from option combinations).

#### Price Adjustments
Option values can modify the final price:

```php
// Example option values with price adjustments
$optionValues = [
    [
        'value' => 'aerox_old',
        'display_value' => 'Aerox Old',
        'price_adjustment' => 0.00 // Base price
    ],
    [
        'value' => 'aerox_new',
        'display_value' => 'Aerox New',
        'price_adjustment' => 25000.00 // +25k for newer model
    ],
    [
        'value' => 'premium_material',
        'display_value' => 'Premium Material',
        'price_adjustment' => 50000.00 // +50k for premium
    ]
];
```

#### Price Calculation
```php
public function calculatePrice(array $selectedOptions)
{
    $basePrice = $this->getBasePrice();
    $totalAdjustment = 0;
    
    foreach ($selectedOptions as $optionValueId) {
        $optionValue = ProductOptionValue::find($optionValueId);
        $totalAdjustment += $optionValue->price_adjustment;
    }
    
    return $basePrice + $totalAdjustment;
}
```

## Availability Management

### Global Product Availability
- `products.is_active` - Controls overall product availability
- Inactive products are hidden from public listings

### Option-Level Availability
- `product_option_values.is_available` - Controls individual option availability
- Unavailable options are grayed out or hidden in the interface

### Stock Management
- `products.stock` - Physical inventory tracking
- Automatic stock reduction on purchase
- Low stock alerts and management

## Admin Interface

### Product Management (`/admin/products-tables`)

**Features:**
- **Product Grid**: Visual overview with images and key metrics
- **Add/Edit Products**: Comprehensive product forms
- **Bulk Operations**: Mass status changes and updates
- **Category Filtering**: Filter by product categories
- **Search Functionality**: Find products by name or description

**Product Form Sections:**

#### Basic Information
- Product name (required)
- Category selection (dropdown)
- Product description (rich text editor)
- Product image upload

#### Inventory & Statistics
- Stock quantity
- Units sold (read-only)
- Number of ratings (read-only)
- Average rating (read-only)
- Active status toggle

#### Product Options Management
- Add/remove options
- Configure option requirements
- Set display order
- Manage option values and pricing

### Option Value Management

**Inline Option Editing:**
```php
// Add option values directly in product form
foreach ($product->productOptions as $option) {
    foreach ($option->productOptionValues as $value) {
        // Edit value properties
        // Set availability status
        // Adjust pricing
    }
}
```

## API Endpoints

### Public API

#### GET `/api/products`
**List all active products with available options**

```json
{
    "data": [
        {
            "id": 1,
            "name": "LED Headlight Kit",
            "category": "Lighting",
            "description": "High-brightness LED headlight kit",
            "image": "led-headlight.jpg",
            "stock": 15,
            "average_rating": 4.8,
            "is_active": true,
            "options": [
                {
                    "id": 1,
                    "option_name": "quantity",
                    "display_name": "Quantity",
                    "is_required": true,
                    "values": [
                        {
                            "id": 1,
                            "value": "single",
                            "display_value": "Single",
                            "price_adjustment": 0,
                            "is_available": true
                        }
                    ]
                }
            ]
        }
    ]
}
```

#### GET `/api/products/{id}`
**Get specific product with detailed options**

#### POST `/api/products/{id}/calculate-price`
**Calculate price for selected options**

Request:
```json
{
    "selected_options": [1, 3, 5]
}
```

Response:
```json
{
    "base_price": 150000,
    "adjustments": [
        {"option_value_id": 1, "adjustment": 0},
        {"option_value_id": 3, "adjustment": 25000},
        {"option_value_id": 5, "adjustment": 10000}
    ],
    "total_price": 185000,
    "formatted_price": "Rp 185,000"
}
```

### Admin API

#### POST `/admin/api/products`
**Create new product with options**

#### PUT `/admin/api/products/{id}`
**Update product information**

#### POST `/admin/api/products/{id}/options`
**Add product option**

#### PUT `/admin/api/product-options/{id}`
**Update product option**

#### DELETE `/admin/api/product-options/{id}`
**Remove product option**

## Frontend Integration

### Product Display Components

#### Product Grid
Product grid display shows products in a responsive card layout with:
- Product images with proper alt tags
- Product names and categories
- Star rating display based on average ratings
- Stock status indicators
- Responsive design for different screen sizes

#### Product Options Selector
```javascript
// Dynamic option selection with price updates
function updateProductPrice() {
    const selectedOptions = [];
    document.querySelectorAll('.option-select').forEach(select => {
        if (select.value) {
            selectedOptions.push(parseInt(select.value));
        }
    });
    
    fetch(`/api/products/${productId}/calculate-price`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ selected_options: selectedOptions })
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('product-price').textContent = data.formatted_price;
    });
}
```

## Inventory Management

### Stock Tracking
- Real-time inventory updates
- Low stock notifications
- Automatic reorder points
- Stock history logging

### Stock Operations
```php
// Reduce stock on purchase
public function reduceStock($quantity)
{
    if ($this->stock >= $quantity) {
        $this->decrement('stock', $quantity);
        $this->increment('sold', $quantity);
        return true;
    }
    return false;
}

// Restock inventory
public function addStock($quantity)
{
    $this->increment('stock', $quantity);
}

// Check if product is in stock
public function isInStock($quantity = 1)
{
    return $this->stock >= $quantity && $this->is_active;
}
```

## Analytics & Reporting

### Sales Metrics
- Total products sold
- Revenue by category
- Top-selling products
- Conversion rates

### Inventory Metrics
- Stock levels
- Turnover rates
- Dead stock identification
- Reorder recommendations

### Customer Metrics
- Product ratings and reviews
- Most requested options
- Customer preferences
- Return/exchange rates

## SEO Optimization

### Product URLs
- SEO-friendly product URLs
- Category-based URL structure
- Proper meta tags and descriptions

### Structured Data
```json
{
    "@type": "Product",
    "name": "LED Headlight Kit",
    "description": "High-brightness LED headlight kit for motorcycles",
    "category": "Lighting",
    "offers": {
        "@type": "Offer",
        "price": "150000",
        "priceCurrency": "IDR",
        "availability": "InStock"
    },
    "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "4.8",
        "reviewCount": "23"
    }
}
```

## Security Considerations

### Input Validation
- Sanitize all product data inputs
- Validate option selections
- Prevent SQL injection attacks
- Secure file upload handling

### Access Control
- Admin-only product management
- Role-based permissions
- Audit logging for changes

## Performance Optimization

### Database Optimization
- Proper indexing on frequently queried fields
- Eager loading of relationships
- Query result caching

### Image Optimization
- Automatic image resizing
- WebP format conversion
- CDN integration
- Lazy loading implementation

## Integration Points

### E-commerce Platforms
- Shopee API integration
- Tokopedia marketplace sync
- Custom checkout processes
- Payment gateway integration

### External Services
- Shipping providers
- Inventory management systems
- Customer review platforms
- Analytics services

## Best Practices

### Product Data Management
1. **Consistent Naming**: Use clear, descriptive product names
2. **Image Standards**: Maintain consistent image dimensions and quality
3. **Option Organization**: Group related options logically
4. **Pricing Strategy**: Regular price review and optimization

### Performance
1. **Image Compression**: Optimize product images
2. **Caching Strategy**: Cache frequently accessed product data
3. **Database Queries**: Minimize N+1 query problems
4. **API Rate Limiting**: Implement appropriate rate limits

## Troubleshooting

### Common Issues

#### Product Not Displaying
- Check `is_active` status
- Verify image file exists
- Ensure category is valid

#### Option Selection Problems
- Validate option requirements
- Check option value availability
- Verify price calculation logic

#### Stock Inconsistencies
- Audit stock reduction logs
- Check for concurrent purchase handling
- Verify inventory update procedures

### Debug Tools
- Product data validation commands
- Stock reconciliation scripts
- Option configuration validators
- Price calculation testers 