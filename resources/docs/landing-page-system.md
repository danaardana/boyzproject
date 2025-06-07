# Landing Page System Documentation

## Overview

The Landing Page System is a comprehensive content management solution that allows dynamic editing of website sections, content blocks, and interactive elements. It provides a flexible structure for managing sections like hero banners, services, testimonials, portfolios, and contact forms.

## Architecture

### Database Structure

The system consists of three main models:

#### 1. Section Model
- **Purpose**: Defines major page sections (hero, about, services, testimonials, etc.)
- **Key Fields**:
  - `name` - Section identifier (e.g., 'hero', 'services', 'testimonials')
  - `title` - Display title for the section
  - `description` - Optional section description
  - `layout` - Layout template to use
  - `is_active` - Whether section is displayed
  - `show_order` - Display order on page

#### 2. SectionContent Model
- **Purpose**: Stores individual content blocks within sections
- **Key Fields**:
  - `section_id` - Foreign key to sections table
  - `content_key` - Identifier for the content block
  - `content_value` - The actual content/text
  - `extra_data` - JSON field for additional metadata (images, links, etc.)
  - `content_type` - Type of content (text, image, video, etc.)
  - `show_order` - Display order within section

#### 3. Content Model
- **Purpose**: Additional content management for specific page elements
- **Key Fields**:
  - `category` - Content category
  - `key` - Content identifier
  - `value` - Content value
  - `type` - Content type
  - `is_active` - Active status

### Controllers

#### LandingPageController
**Main Functions:**
- `index()` - Display the public landing page
- `getSectionData()` - Retrieve section content for display
- `renderSection()` - Render specific section templates

#### AdminController
**Landing Page Management Functions:**
- `landingPageTables()` - Admin interface for managing sections
- `subsectionTables()` - Admin interface for managing section content
- `update()` - Update section content

## Section Types

### 1. Hero Section
- **Purpose**: Main banner/hero area
- **Content Types**:
  - Primary heading
  - Subtitle/description
  - Call-to-action buttons
  - Background images/videos
- **Layout Options**: Full-width, split, carousel

### 2. About Section
- **Purpose**: Company/business information
- **Content Types**:
  - About text
  - Mission/vision statements
  - Team information
  - Company statistics

### 3. Services Section
- **Purpose**: Service offerings display
- **Content Types**:
  - Service titles and descriptions
  - Service icons/images
  - Pricing information
  - Feature lists

### 4. Testimonials Section
- **Purpose**: Customer feedback and reviews
- **Content Types**:
  - Customer testimonials
  - Customer photos
  - Ratings/stars
  - Company affiliations

### 5. Portfolio Section
- **Purpose**: Showcase work/projects
- **Content Types**:
  - Project images
  - Project descriptions
  - Project categories
  - Project links

### 6. Contact Section
- **Purpose**: Contact information and forms
- **Content Types**:
  - Contact details
  - Contact forms
  - Location maps
  - Social media links

## Admin Interface

### Section Management (`/admin/landingpage-tables`)

**Features:**
- **Grid View**: Visual overview of all sections
- **Add/Edit Sections**: Modal forms for section management
- **Status Control**: Toggle section visibility
- **Order Management**: Drag-and-drop reordering
- **Preview**: Live preview of changes

**Form Fields:**
- **Basic Information**:
  - Section name
  - Display title
  - Description
  - Content area
- **Settings**:
  - Button text and URL
  - Layout selection
  - Show order
  - Active status

### Content Management (`/admin/subsection-tables`)

**Features:**
- **Content Blocks**: Manage individual content within sections
- **Rich Editor**: WYSIWYG editor for content
- **Media Management**: Image/file uploads
- **JSON Metadata**: Extra data configuration

**Form Fields:**
- **Content Information**:
  - Category selection
  - Content title
  - Subtitle
  - Description/content
- **Settings**:
  - Content type
  - Show order
  - Extra data (JSON)

## Content Structure Examples

### Hero Section Content
```json
{
  "section_id": 1,
  "content_key": "hero_title",
  "content_value": "Welcome to Boy Projects",
  "extra_data": {
    "background_image": "hero-bg.jpg",
    "button_text": "Get Started",
    "button_url": "#contact"
  }
}
```

### Service Block
```json
{
  "section_id": 2,
  "content_key": "service_mounting",
  "content_value": "Professional motorcycle mounting and body modification services",
  "extra_data": {
    "icon": "wrench-icon.svg",
    "price": "Starting from Rp 150,000",
    "features": ["Quality Materials", "Expert Installation", "Warranty Included"]
  }
}
```

### Testimonial Entry
```json
{
  "section_id": 4,
  "content_key": "customer_review_1",
  "content_value": "Excellent service and quality products!",
  "extra_data": {
    "customer_name": "John Doe",
    "customer_image": "customer-1.jpg",
    "rating": 5,
    "company": "ABC Company"
  }
}
```

## Layout System

### Available Layouts
1. **Default**: Standard section layout
2. **Full Width**: Edge-to-edge content
3. **Split**: Two-column layout
4. **Grid**: Multi-column grid layout
5. **Carousel**: Sliding content
6. **Masonry**: Dynamic grid layout

### Layout Configuration
```php
// In Section model
public function getLayoutOptions()
{
    return [
        'default' => 'Default Layout',
        'full-width' => 'Full Width',
        'split' => 'Split Layout',
        'grid' => 'Grid Layout',
        'carousel' => 'Carousel',
        'masonry' => 'Masonry'
    ];
}
```

## API Endpoints

### Public Endpoints
- `GET /` - Display landing page
- `GET /api/sections` - Get all active sections
- `GET /api/sections/{id}` - Get specific section content

### Admin Endpoints
- `GET /admin/landingpage-tables` - Section management interface
- `GET /admin/subsection-tables` - Content management interface
- `PUT /admin/section-content/{id}` - Update section content
- `POST /admin/sections` - Create new section
- `DELETE /admin/sections/{id}` - Delete section

## Content Types

### Supported Content Types
1. **Text**: Plain text content
2. **HTML**: Rich HTML content
3. **Markdown**: Markdown formatted content
4. **Image**: Image files with metadata
5. **Video**: Video embeds and files
6. **JSON**: Structured data

### Content Validation
```php
// Content type validation rules
public static function getValidationRules($type)
{
    return match($type) {
        'text' => ['required', 'string', 'max:1000'],
        'html' => ['required', 'string'],
        'image' => ['required', 'image', 'max:2048'],
        'video' => ['required', 'url'],
        'json' => ['required', 'json'],
        default => ['required', 'string']
    };
}
```

## SEO Features

### Meta Data Management
- Page titles
- Meta descriptions
- Open Graph tags
- Twitter Card tags
- Structured data markup

### URL Management
- Friendly URLs
- Canonical URLs
- Redirect management

## Performance Optimization

### Caching Strategy
- Section content caching
- Image optimization
- CDN integration
- Lazy loading

### Database Optimization
- Proper indexing
- Query optimization
- Eager loading relationships

## Integration Points

### External Services
- **Social Media**: Instagram/TikTok feeds
- **Analytics**: Google Analytics integration
- **Email**: Newsletter subscriptions
- **Chat**: Customer support integration

### Third-party APIs
- Payment gateways
- Shipping providers
- Inventory systems
- CRM integration

## Security Features

### Content Security
- Input sanitization
- XSS prevention
- File upload validation
- Content approval workflow

### Access Control
- Admin authentication
- Role-based permissions
- Content editing restrictions

## Mobile Responsiveness

### Responsive Design
- Mobile-first approach
- Flexible layouts
- Touch-optimized interactions
- Progressive web app features

## Maintenance

### Regular Tasks
- Content backup
- Image optimization
- Cache clearing
- Performance monitoring

### Monitoring
- Page load times
- User engagement metrics
- Error tracking
- Uptime monitoring

## Best Practices

### Content Management
1. **Consistent Naming**: Use clear, descriptive section names
2. **Image Optimization**: Compress images before upload
3. **Content Planning**: Plan section structure before implementation
4. **Regular Updates**: Keep content fresh and relevant

### Performance
1. **Image Sizes**: Use appropriate image dimensions
2. **Caching**: Enable proper caching strategies
3. **Minification**: Minify CSS/JS assets
4. **CDN Usage**: Use CDN for static assets

### SEO
1. **Meta Tags**: Include proper meta descriptions
2. **Alt Text**: Add descriptive alt text for images
3. **Structured Data**: Implement schema markup
4. **Page Speed**: Optimize for fast loading times

## Troubleshooting

### Common Issues
1. **Content Not Displaying**: Check section active status
2. **Layout Issues**: Verify layout configuration
3. **Image Problems**: Check file permissions and paths
4. **Performance Issues**: Review caching and optimization

### Debug Tools
- Laravel Debugbar
- Query logging
- Error tracking
- Performance profiling 