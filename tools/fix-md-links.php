<?php
/**
 * Fix markdown links missing .md extension
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
     * Improved Regex Explanation:
     * 1. \] \(              : Match the end of a markdown link text and start of URL
     * 2. ( (?!\w+:\/\/)     : Negative lookahead to ensure it's NOT an external URL (http:// etc)
     * 3. (?: \.\.\/ | \.\/ | classes\/ )+ : Match relative steps (../), current steps (./), or the classes root
     * 4. [^)\s.]+           : Match the path characters (excluding dots and spaces to avoid files with extensions)
     * 5. (?<!\.md)          : Negative lookbehind to ensure we don't double up if .md already exists
     * 6. \)                 : Match closing parenthesis
     */
    $content = preg_replace(
        '/\]\(((?!\w+:\/\/)(?:(?:\.\.\/)+|(?:\.\/)+|classes\/)[^)\s.]+)(?<!\.md)\)/i',
        ']($1.md)',
        $content
    );

    // Specifically handle ClassName links that have no path prefix but are relative in MD
    // e.g. [LinkAddition](LinkAddition) -> [LinkAddition](LinkAddition.md)
    $content = preg_replace(
        '/\]\(([A-Z][a-zA-Z0-9_]*)(?<!\.md)\)/',
        ']($1.md)',
        $content
    );

    if ($content !== $original) {
        file_put_contents($file->getPathname(), $content);
        echo "Fixed: {$file->getPathname()}\n";
    }
}

echo "Done!\n";
