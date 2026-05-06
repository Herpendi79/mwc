# Library Management and Build Commands

This project uses a custom mechanism to copy and manage external libraries from `node_modules` into the `resources/assets/libs` folder.

## Library Configuration

The list of packages to be copied is defined in:
- `package-libs-config.json`

## Commands

### 1. Manual Library Sync
To manually sync libraries from `node_modules` to `resources/assets/libs`, run the following command:

```bash
node preload.js
```

### 2. Development Mode
When you run the development server, the libraries are automatically synced:

```bash
npm run dev
```

### 3. Production Build
When building for production, the libraries are synced to `resources/assets/libs` and also copied to `public/assets/libs` for the final bundle:

```bash
npm run build
```

## How it Works

1.  **`preload.js`**: A script that reads `package-libs-config.json`, finds the corresponding directories in `node_modules` (checking for `/dist` folders), and copies them to `resources/assets/libs`.
2.  **`vite.config.mjs`**: 
    - The `preload-script` plugin ensures that `preload.js` runs whenever the Vite configuration is resolved (on dev server start or build start).
    - The `copy-specific-packages` plugin ensures that during the build process, the libraries are also placed in the `public/assets/libs` directory.

## Adding a New Library

1.  Install the package via npm:
    ```bash
    npm install package-name
    ```
2.  Add the package name to the `packagesToCopy` array in `package-libs-config.json`.
3.  Run `node preload.js` or start the dev server to sync the new library.
