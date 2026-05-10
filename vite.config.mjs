import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import { execSync } from 'child_process';
import fs from 'fs-extra';
import path from 'path';
import { fileURLToPath } from 'url';

// Convert the file URL to a file path
const __filename = fileURLToPath(import.meta.url);
// Get the directory name
const __dirname = path.dirname(__filename);

export default defineConfig({
    plugins: [
        {
            name: "preload-script",
            configResolved() {
                // Run the preload script
                try {
                    execSync("node ./preload.js", { stdio: "inherit" });
                } catch (error) {
                    console.error("Error running preload script:", error);
                }
            },
        },
        laravel({
            input: [
                "resources/assets/css/icons.css",
                "resources/assets/css/plugins.css",
                "resources/assets/css/tailwind.css",
                "resources/js/app.js",
                "resources/assets/js/search.js",
            ],
            refresh: true,
        }),
        tailwindcss(),
        {
            name: "copy-specific-packages",
            async writeBundle() {
                const outputPath = path.resolve(__dirname, "public/assets"); // Adjust to your Laravel public path
                const resourcesPath = path.resolve(
                    __dirname,
                    "resources/assets",
                );
                const configPath = path.resolve(
                    __dirname,
                    "package-libs-config.json",
                );

                try {
                    const configContent = await fs.readFile(
                        configPath,
                        "utf-8",
                    );
                    const { packagesToCopy } = JSON.parse(configContent);

                    for (const packageName of packagesToCopy) {
                        const destPackagePath = path.join(
                            outputPath,
                            "libs",
                            packageName,
                        );
                        const destPackagePathResources = path.join(
                            resourcesPath,
                            "libs",
                            packageName,
                        );

                        const sourcePath = fs.existsSync(
                            path.join(
                                __dirname,
                                "node_modules",
                                packageName + "/dist",
                            ),
                        )
                            ? path.join(
                                  __dirname,
                                  "node_modules",
                                  packageName + "/dist",
                              )
                            : path.join(__dirname, "node_modules", packageName);

                        try {
                            await fs.access(sourcePath, fs.constants.F_OK);

                            // Copy to public/assets/libs (for production build output)
                            await fs.ensureDir(path.dirname(destPackagePath));
                            await fs.copy(sourcePath, destPackagePath);

                            // Copy to resources/assets/libs (for development/source consistency)
                            await fs.ensureDir(
                                path.dirname(destPackagePathResources),
                            );
                            await fs.copy(sourcePath, destPackagePathResources);
                        } catch (error) {
                            console.error(
                                `Package ${packageName} does not exist at ${sourcePath}`,
                            );
                        }
                    }

                    // Copy other assets (images, fonts) to public
                    const assetFolders = ["images", "fonts"];
                    for (const folder of assetFolders) {
                        const src = path.join(resourcesPath, folder);
                        const dest = path.join(outputPath, folder);
                        if (fs.existsSync(src)) {
                            await fs.ensureDir(dest);
                            await fs.copy(src, dest);
                        }
                    }
                } catch (error) {
                    console.error(
                        "Error copying and renaming packages:",
                        error,
                    );
                }
            },
        },
    ],
    server: {
        watch: {
            ignored: ["**/storage/framework/views/**"],
        },
    },
});
