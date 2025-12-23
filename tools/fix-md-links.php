<?php
/**
 * Fix markdown links missing .md extension and incorrect directory paths.
 */
$dir = $argv[1] ?? 'docs/markdown';

if (!is_dir($dir)) {
    echo "Directory not found: $dir\n";
    exit(1);
}

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS)
);

foreach ($iterator as $file) {
    if ($file->getExtension() !== 'md') {
        continue;
    }

    $content = file_get_contents($file->getPathname());
    $original = $content;

    /**
     * FIX 1: Add .md extension to local paths that don't have one.
     * This targets links like [Text](../Path/ClassName) but ignores external URLs.
     */
    $content = preg_replace(
        '/\]\(((?!\w+:\/\/)(?:(?:\.\.\/)+|(?:\.\/)+|classes\/)[^)\s.]+)(?<!\.md)\)/i',
        ']($1.md)',
        $content
    );

    /**
     * FIX 2: Correct links to base PHP classes (like Exception)
     * If a link points to ../../../Exception.md, it's often broken.
     * This logic detects "Parent class" or "Throws" links pointing to root classes
     * and ensures they are reachable or correctly formatted.
     */
    $content = preg_replace_callback('/\]\(((\.\.\/)+)([^)]+\.md)\)/', function($matches) {
        $pathPrefix = $matches[1];
        $fileName = $matches[3];

        // List of common base PHP classes that often get broken root links
        $baseClasses = ['Exception.md', 'JsonException.md', 'RuntimeException.md', 'InvalidArgumentException.md', 'Throwable.md'];

        if (in_array($fileName, $baseClasses)) {
            // Option A: Keep them relative but ensure they don't break.
            // In many cases, these files don't actually exist in your MD export.
            // If you want to link back to the class itself if the file is missing:
            return "]($fileName)";
        }

        return $matches[0];
    }, $content);

    /**
     * FIX 3: Specific ClassName-only links
     * e.g. [LinkAddition](LinkAddition) -> [LinkAddition](LinkAddition.md)
     */
    $content = preg_replace(
        '/\]\(([A-Z][a-zA-Z0-9_]*)(?<!\.md)\)/',
        ']($1.md)',
        $content
    );

    if ($content !== $original) {
        file_put_contents($file->getPathname(), $content);
        echo "Fixed links in: {$file->getPathname()}\n";
    }
}

echo "Done fixing documentation links!\n";
