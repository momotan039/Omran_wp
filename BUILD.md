# Building Tailwind CSS

This theme uses Tailwind CSS with a proper build process instead of the CDN.

## Initial Setup

1. Install Node.js (if not already installed): https://nodejs.org/

2. Install dependencies:
```bash
npm install
```

## Building CSS

### Production Build (Minified)
```bash
npm run build:css
```

### Development Build (Watch Mode)
```bash
npm run watch:css
```

This will watch for changes and automatically rebuild the CSS.

## File Structure

- `assets/css/src/tailwind.css` - Source file with Tailwind directives
- `assets/css/tailwind.css` - Built/compiled CSS (generated, do not edit)
- `tailwind.config.js` - Tailwind configuration with custom colors
- `package.json` - Dependencies and build scripts

## Custom Colors

The custom colors (primary, secondary, brand, etc.) are defined in `tailwind.config.js` and will be included in the built CSS file.

## Important Notes

- Always run `npm run build:css` before deploying to production
- The built `tailwind.css` file should be committed to the repository
- Do not edit `assets/css/tailwind.css` directly - edit the source file instead

