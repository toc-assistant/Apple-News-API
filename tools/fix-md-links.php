<?php
/**
 * Advanced Markdown Link & Path Fixer
 * Logic:
 * 1. Checks if a target .md file exists.
 * 2. If not, checks if it exists as a directory.
 * 3. Redirects broken "classes/Exception" style links to the local directory.
 */

$baseDir = realpath($argv[1] ?? 'docs/markdown');

if (!$baseDir || !is_dir($baseDir)) {
    echo "Directory not found: " . ($argv[1] ?? 'docs/markdown') . "\n";
    exit(1);
}

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($baseDir, RecursiveDirectoryIterator::SKIP_DOTS)
);

foreach ($iterator as $file) {
    if ($file->getExtension() !== 'md') continue;

    $filePath = $file->getPathname();
    $currentFileDir = dirname($filePath);
    $content = file_get_contents($filePath);
    $originalContent = $content;

    // Regex to find Markdown links: [text](url) - ignores external http/https
    $content = preg_replace_callback('/\]\((?!https?:\/\/)([^)]+)\)/', function($matches) use ($currentFileDir, $baseDir) {
        $originalUrl = $matches[1];

        // Remove .md extension for internal checks to standardize
        $cleanUrl = preg_replace('/\.md$/', '', $originalUrl);

        // Step 1: Determine the intended disk path
        if (preg_match('/^(\.\/)?classes\//', $cleanUrl)) {
            // Path relative to docs root
            $testPath = $baseDir . DIRECTORY_SEPARATOR . ltrim(preg_replace('/^(\.\/)?classes\//', '', $cleanUrl), '/');
        } else {
            // Path relative to current file
            $testPath = $currentFileDir . DIRECTORY_SEPARATOR . ltrim($cleanUrl, '/');
        }

        // Step 2: Test File Presence
        if (file_exists($testPath . '.md')) {
            return "]($cleanUrl.md)";
        }

        // Step 3: Test Directory Presence
        if (is_dir($testPath)) {
            return "]($cleanUrl/)";
        }

        /**
         * Step 4: Special Fix for "Broken Root Links"
         * Example: Current file is in classes/TomGould/AppleNews/Exception/AppleNewsException.md
         * Broken link in that file points to: classes/Exception
         * Logic: We redirect it to the folder containing the current file.
         */
        if (str_contains($originalUrl, 'classes/')) {
            $urlParts = explode('/', rtrim($cleanUrl, '/'));
            $targetName = end($urlParts);

            // Fixed variable name from previous error
            $basePhpClasses = ['Exception', 'JsonException', 'RuntimeException', 'Throwable', 'InvalidArgumentException', 'JsonSerializable', 'DateTimeImmutable', 'DateTimeInterface'];

            if (in_array($targetName, $basePhpClasses)) {
                // Determine relative path back to the current folder
                return "](./)";
            }
        }

        return $matches[0];
    }, $content);

    if ($content !== $originalContent) {
        file_put_contents($filePath, $content);
        echo "Fixed paths in: " . str_replace($baseDir, '', $filePath) . "\n";
    }
}

echo "Path fixing complete!\n";
