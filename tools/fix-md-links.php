<?php
/**
 * Advanced Markdown Link & Path Fixer
 * Logic:
 * 1. Checks if a target .md file exists.
 * 2. If not, checks if it exists as a directory.
 * 3. Identifies links to global PHP classes (e.g., Exception, Throwable)
 * that point to the wrong directory and redirects them to the current folder.
 */

$baseDir = realpath($argv[1] ?? 'docs/markdown');

if (!$baseDir || !is_dir($baseDir)) {
    echo "Directory not found: " . ($argv[1] ?? 'docs/markdown') . "\n";
    exit(1);
}

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($baseDir, RecursiveDirectoryIterator::SKIP_DOTS)
);

// Standard PHP classes that phpDocumentor often links incorrectly to the root
$basePhpClasses = [
    'Exception', 'JsonException', 'RuntimeException', 'Throwable',
    'InvalidArgumentException', 'JsonSerializable', 'DateTimeImmutable',
    'DateTimeInterface', 'DateTime'
];

foreach ($iterator as $file) {
    if ($file->getExtension() !== 'md') continue;

    $filePath = $file->getPathname();
    $currentFileDir = dirname($filePath);
    $content = file_get_contents($filePath);
    $originalContent = $content;

    // Regex to find Markdown links: [text](url) - ignores external http/https
    $content = preg_replace_callback('/\]\((?!https?:\/\/)([^)]+)\)/', function($matches) use ($currentFileDir, $baseDir, $basePhpClasses) {
        $originalUrl = $matches[1];

        // Remove .md extension and any trailing slashes for standardized checks
        $cleanUrl = preg_replace('/\.md$/', '', rtrim($originalUrl, '/'));

        // Step 1: Determine the intended disk path
        if (preg_match('/^(\.\/)?classes\//', $cleanUrl)) {
            // Path is root-relative (starts with classes/)
            $testPath = $baseDir . DIRECTORY_SEPARATOR . ltrim(preg_replace('/^(\.\/)?classes\//', '', $cleanUrl), '/');
        } else {
            // Path is relative to the current file
            $testPath = $currentFileDir . DIRECTORY_SEPARATOR . ltrim($cleanUrl, '/');
        }

        // Step 2: Test File Presence (with .md extension)
        if (file_exists($testPath . '.md')) {
            return "]($cleanUrl.md)";
        }

        // Step 3: Test Directory Presence
        if (is_dir($testPath)) {
            return "]($cleanUrl/)";
        }

        /**
         * Step 4: Fix Broken Links to Global PHP Classes
         * If the URL ends with a known base class name and the file doesn't exist at the tested path:
         */
        $urlParts = explode('/', $cleanUrl);
        $targetName = end($urlParts);

        if (in_array($targetName, $basePhpClasses)) {
            // Force the link to point to the current directory where the class file resides.
            // On GitHub, this will reload the current folder view or stay on page if it's a self-reference.
            return "](./)";
        }

        return $matches[0];
    }, $content);

    if ($content !== $originalContent) {
        file_put_contents($filePath, $content);
        echo "Fixed paths in: " . str_replace($baseDir, '', $filePath) . "\n";
    }
}

echo "Path fixing complete!\n";
