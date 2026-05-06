import fs from 'fs-extra';
import path from 'path';
import { fileURLToPath } from 'url';

// Convert the file URL to a file path
const __filename = fileURLToPath(import.meta.url);
// Get the directory name
const __dirname = path.dirname(__filename);

// Define the source and destination directories
const nodeModulesPath = path.resolve(__dirname, 'node_modules');
const destinationBasePath = path.resolve(__dirname, 'resources/assets/libs');
const publicAssetsPath = path.resolve(__dirname, 'public/assets');
const resourcesAssetsPath = path.resolve(__dirname, 'resources/assets');

// Load the package configuration file
const configPath = path.resolve(__dirname, 'package-libs-config.json');
let packagesToCopy = [];

try {
    const configContent = fs.readFileSync(configPath, 'utf-8');
    const config = JSON.parse(configContent);
    packagesToCopy = config.packagesToCopy || [];
} catch (err) {
    console.error('Error reading package-libs-config.json:', err);
}

// Function to copy a package
async function copyPackage(packageName) {
    const sourcePath = (fs.existsSync(path.join(__dirname, 'node_modules', packageName + "/dist"))) ?
        path.join(__dirname, 'node_modules', packageName + "/dist")
        : path.join(__dirname, 'node_modules', packageName);

    // Check if the source path exists
    if (!fs.existsSync(sourcePath)) {
        console.error(`Source path does not exist for package: ${packageName}`);
        return;
    }

    const destinationPath = path.join(destinationBasePath, packageName);

    try {
        // Ensure the destination directory exists
        await fs.ensureDir(destinationPath);
        // Copy the package from node_modules to the destination
        await fs.copy(sourcePath, destinationPath);
        console.log(`Copied ${packageName} successfully.`);
    } catch (err) {
        console.error(`Error copying ${packageName}:`, err);
    }
}

// Function to copy assets (images, fonts, etc) from resources to public
async function copyAssets() {
    const directoriesToMirror = ["images", "fonts", "js", "css", "libs"];
    for (const folder of directoriesToMirror) {
        const src = path.join(resourcesAssetsPath, folder);
        const dest = path.join(publicAssetsPath, folder);

        if (fs.existsSync(src)) {
            try {
                await fs.ensureDir(dest);
                await fs.copy(src, dest);
                console.log(`Copied ${folder} to public successfully.`);
            } catch (err) {
                console.error(`Error copying ${folder}:`, err);
            }
        }
    }
}

// Function to copy all configured packages
async function copyAllPackages() {
    for (const packageName of packagesToCopy) {
        await copyPackage(packageName);
    }
}

// Copy all specified packages and assets
async function preload() {
    await copyAllPackages();
    await copyAssets();
}

// Execute the preload function
preload().then(() => {
    console.log('Preload completed successfully.');
}).catch(err => {
    console.error('Error during preload:', err);
});
