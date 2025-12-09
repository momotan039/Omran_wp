# Building Tailwind CSS

Build process for Tailwind CSS in the theme.

## Setup
1. Install Node.js: https://nodejs.org/
2. Install dependencies: `npm install`

## Building CSS

**Production Build (Minified)**
```bash
npm run build:css
```

**Development Build (Watch Mode)**
```bash
npm run watch:css
```

## File Structure
- `assets/css/src/tailwind.css` - Source file
- `assets/css/tailwind.css` - Built CSS (generated)
- `tailwind.config.js` - Tailwind configuration
- `package.json` - Dependencies and scripts

## Important Notes
- Always run `npm run build:css` before deploying
- Commit the built `tailwind.css` file
- Don't edit `assets/css/tailwind.css` directly

