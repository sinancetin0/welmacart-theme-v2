# WelmaCart v2 - Premium Fashion WordPress Theme

<div align="center">
  <img src="assets/images/logo.svg" alt="WelmaCart Logo" width="200">
  
  **Modern, minimalist WordPress e-commerce theme for fashion brands**
  
  [![WordPress](https://img.shields.io/badge/WordPress-6.0%2B-blue.svg)](https://wordpress.org)
  [![WooCommerce](https://img.shields.io/badge/WooCommerce-8.0%2B-purple.svg)](https://woocommerce.com)
  [![PHP](https://img.shields.io/badge/PHP-8.0%2B-777BB4.svg)](https://php.net)
  [![License](https://img.shields.io/badge/License-GPL--2.0-green.svg)](LICENSE)
</div>

## 🌟 Features

### 🎨 **Apple-Inspired Design**
- Minimalist, clean layout with ample whitespace
- SF Pro Display font family integration
- Sophisticated color system with CSS custom properties
- Responsive design for all devices

### 🛒 **E-Commerce Ready**
- Full WooCommerce integration
- Custom product layouts and grids
- Advanced filtering system
- Streamlined checkout process
- Product zoom and gallery features

### 🖼️ **Advanced Image Management**
- Optimized hero banner system with responsive images
- Custom image sizes for different screen resolutions
- WebP format support for modern browsers
- High-quality image rendering with CSS optimizations

### 🚀 **Performance Optimized**
- Lazy loading for images
- Critical CSS implementation
- Asset minification and combination
- Memory-optimized image processing

### 📱 **Mobile-First Design**
- Responsive breakpoints for all devices
- Touch-friendly navigation
- Mobile-optimized product cards
- Progressive Web App ready

## 🛠️ Installation

1. **Download the theme**
   ```bash
   git clone https://github.com/yourusername/welmacart-v2.git
   cd welmacart-v2
   ```

2. **Upload to WordPress**
   - Upload the theme folder to `/wp-content/themes/`
   - Or install via WordPress admin: Appearance > Themes > Add New > Upload

3. **Activate the theme**
   - Go to Appearance > Themes
   - Activate "WelmaCart v2"

4. **Install required plugins**
   - WooCommerce (required)
   - Advanced Custom Fields Pro (recommended)

## 📁 Theme Structure

```
welmacart-v2/
├── assets/
│   ├── css/           # Stylesheets
│   ├── js/            # JavaScript files
│   └── images/        # Theme images
├── inc/               # PHP includes
│   ├── setup.php      # Theme setup
│   ├── enqueue.php    # Assets management
│   ├── woocommerce.php # WooCommerce integration
│   └── acf-fields.php # Custom fields
├── template-parts/    # Reusable template parts
├── woocommerce/      # WooCommerce templates
└── page-templates/   # Custom page templates
```

## 🎯 Key Components

### Hero Banner System
- Responsive image optimization
- Custom image sizes (Desktop: 1920x1080, Mobile: 768x768, Tablet: 1366x768)
- Hardware-accelerated animations
- High-DPI display support

### Product Features
- Custom ACF fields for product attributes
- Style combination recommendations
- Material type and care instructions
- Seasonal collections grouping

### Account System
- Apple-style account dashboard
- Clean navigation structure
- Responsive user interface
- Order management integration

## 🎨 Customization

### CSS Custom Properties
The theme uses CSS custom properties for easy customization:

```css
:root {
  --color-primary: #1a1a1a;
  --color-secondary: #f5f5f5;
  --font-primary: 'SF Pro Display', sans-serif;
  --transition-fast: 0.2s ease;
  --transition-slow: 0.4s ease;
}
```

### Image Optimization
Custom image sizes are automatically generated:
- `hero-banner`: 1920x1080 (Desktop)
- `hero-banner-mobile`: 768x768 (Mobile)
- `hero-banner-tablet`: 1366x768 (Tablet)

## 🔧 Development

### Prerequisites
- PHP 8.0+
- WordPress 6.0+
- WooCommerce 8.0+
- Node.js (for development)

### Development Setup
```bash
# Install dependencies
npm install

# Watch for changes
npm run dev

# Build for production
npm run build
```

### Code Structure
- **Modular architecture** under `inc/` directory
- **Component-based** template parts
- **Performance-optimized** asset loading
- **SEO-friendly** markup structure

## 📱 Responsive Breakpoints

```css
/* Mobile First */
@media (min-width: 768px)  { /* Tablet */ }
@media (min-width: 1024px) { /* Desktop */ }
@media (min-width: 1200px) { /* Large Desktop */ }
@media (min-width: 1400px) { /* Extra Large */ }
```

## 🚀 Performance Features

- **Image Lazy Loading**: Automatic lazy loading for better performance
- **WebP Support**: Modern image format with fallbacks
- **CSS Optimization**: Critical CSS and minification
- **Memory Management**: Optimized image processing
- **Caching Ready**: Compatible with popular caching plugins

## 🎯 SEO Features

- **Schema Markup**: Rich snippets for products
- **Open Graph**: Social media optimization
- **Meta Tags**: Comprehensive meta tag management
- **Sitemap Ready**: XML sitemap compatibility

## 🛡️ Security

- **Sanitized Inputs**: All user inputs are properly sanitized
- **CSRF Protection**: WordPress nonce verification
- **SQL Injection Prevention**: Prepared statements
- **XSS Protection**: Output escaping

## 📊 Browser Support

- ✅ Chrome 90+
- ✅ Firefox 85+
- ✅ Safari 14+
- ✅ Edge 90+
- ✅ Mobile Safari (iOS 14+)
- ✅ Chrome Mobile (Android 10+)

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

This theme is licensed under the GPL v2 or later.

```
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.
```

## 🆘 Support

- **Documentation**: [Theme Documentation](https://github.com/yourusername/welmacart-v2/wiki)
- **Issues**: [GitHub Issues](https://github.com/yourusername/welmacart-v2/issues)
- **Discussions**: [GitHub Discussions](https://github.com/yourusername/welmacart-v2/discussions)

## 🙏 Credits

- **Design Inspiration**: Apple Design Guidelines
- **Fonts**: SF Pro Display (Apple)
- **Icons**: Custom SVG icons
- **Framework**: WordPress & WooCommerce

## 📈 Changelog

### v2.0.0 (Latest)
- ✨ Complete redesign with Apple-inspired aesthetics
- 🛒 Advanced WooCommerce integration
- 📱 Mobile-first responsive design
- 🖼️ Optimized image management system
- ⚡ Performance improvements
- 🎨 CSS custom properties system
- 🔧 Modular architecture

---

<div align="center">
  <strong>Made with ❤️ for modern fashion brands</strong>
</div>
