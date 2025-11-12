<?php

declare(strict_types=1);

$records = [
    'php' => __DIR__ . '/storage/php-cli.json',
    '@php' => __DIR__ . '/storage/composer-php.json',
];

$results = [];
foreach ($records as $label => $file) {
    $payload = null;
    if (is_file($file)) {
        $contents = file_get_contents($file);
        $payload = $contents === false ? null : json_decode($contents, true);
    }

    $results[$label] = [
        'file' => $file,
        'found' => is_array($payload),
        'data' => is_array($payload) ? $payload : null,
    ];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PHP Version Test</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; margin: 2rem; line-height: 1.4; }
        table { border-collapse: collapse; width: 100%; max-width: 40rem; }
        th, td { border: 1px solid #ccc; padding: 0.5rem; text-align: left; }
        th { background: #f5f5f5; }
        code { background: #f1f1f1; padding: 0.1rem 0.25rem; border-radius: 3px; }
    </style>
</head>
<body>
    <h1>PHP Version Test</h1>
    <p>Server runtime: <strong><?php echo htmlspecialchars(PHP_VERSION, ENT_QUOTES, 'UTF-8'); ?></strong></p>

    <p>Run <code>composer run build</code> to capture CLI runtime details for both <code>php</code> and <code>@php</code>.</p>

    <table>
        <thead>
            <tr>
                <th>Invoker</th>
                <th>Status</th>
                <th>Version</th>
                <th>Binary</th>
                <th>Written At</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($results as $label => $result): ?>
            <tr>
                <td><code><?php echo htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?></code></td>
                <?php if ($result['found']): ?>
                    <td>OK (<?php echo htmlspecialchars($result['file'], ENT_QUOTES, 'UTF-8'); ?>)</td>
                    <td><?php echo htmlspecialchars((string) $result['data']['php_version'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars((string) $result['data']['php_binary'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars((string) $result['data']['written_at'], ENT_QUOTES, 'UTF-8'); ?></td>
                <?php else: ?>
                    <td colspan="4">No data yet (expected file: <?php echo htmlspecialchars($result['file'], ENT_QUOTES, 'UTF-8'); ?>)</td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
