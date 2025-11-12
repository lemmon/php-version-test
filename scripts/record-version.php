<?php

declare(strict_types=1);

if ($argc < 2) {
    fwrite(STDERR, "Usage: php scripts/record-version.php <output-file>\n");
    exit(1);
}

$target = $argv[1];
$dir = dirname($target);

if (!is_dir($dir) && !mkdir($dir, 0777, true) && !is_dir($dir)) {
    fwrite(STDERR, "Unable to create directory: {$dir}\n");
    exit(1);
}

$payload = json_encode(
    [
        'written_at' => date(DATE_ATOM),
        'php_version' => PHP_VERSION,
        'php_binary' => PHP_BINARY,
    ],
    JSON_PRETTY_PRINT
);

if ($payload === false) {
    fwrite(STDERR, "Failed to encode payload\n");
    exit(1);
}

if (file_put_contents($target, $payload . PHP_EOL) === false) {
    fwrite(STDERR, "Failed to write {$target}\n");
    exit(1);
}
