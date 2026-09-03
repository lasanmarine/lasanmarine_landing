# Frontend Build System

## Development Setup

### Install Dependencies
```bash
cd fe
npm install
```

### Development Mode (with HMR)
```bash
npm run dev
```

This will:
- Start Vite dev server on `http://localhost:5173`
- Enable Hot Module Replacement (HMR)
- Watch for file changes and auto-reload CSS without full page refresh

### Production Build
```bash
npm run build
```

This will compile SCSS to CSS and bundle JavaScript files into:
- `fe/dist/app.css`
- `fe/dist/app.js`
- `fe/dist/vendor.js`

## Project Structure

```
fe/
├── src/
│   ├── styles/
│   │   ├── components/
│   │   ├── base.scss
│   │   ├── components.scss
│   │   └── layout.scss
│   ├── js/
│   ├── main.js
│   └── main.scss
├── dist/          (generated)
├── node_modules/  (generated)
├── vite.config.js
└── package.json
```

## Tech Stack

- **VanillaJS** (no jQuery)
- **SCSS**
- **Tailwind CSS** (Latest version)
- **Vite** (Build tool with HMR)
- **PostCSS** + **Autoprefixer**

## Using Tailwind CSS

Tailwind CSS is integrated and ready to use. You can use Tailwind utility classes directly in your PHP templates:

```php
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold text-gray-900">Hello World</h1>
</div>
```

### Custom Tailwind Configuration

Edit `tailwind.config.js` to customize Tailwind settings, add custom colors, fonts, etc.

### SCSS + Tailwind

You can combine Tailwind utilities with custom SCSS:

```scss
// In your component SCSS files
.custom-button {
    @apply px-4 py-2 bg-blue-500 text-white rounded;
    
    // Add custom styles
    &:hover {
        transform: scale(1.05);
    }
}
```
