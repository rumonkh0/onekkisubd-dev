<?php

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? ''
);

// Check if file exists directly from root or public
$filePath = null;
if ($uri !== '/') {
    if (file_exists(__DIR__ . $uri) && !is_dir(__DIR__ . $uri)) {
        $filePath = __DIR__ . $uri;
    } elseif (file_exists(__DIR__ . '/public' . $uri) && !is_dir(__DIR__ . '/public' . $uri)) {
        $filePath = __DIR__ . '/public' . $uri;
    } elseif (str_starts_with($uri, '/public/') && file_exists(__DIR__ . substr($uri, 7)) && !is_dir(__DIR__ . substr($uri, 7))) {
        $filePath = __DIR__ . substr($uri, 7);
    }
}

if ($filePath) {
    // If running with root as docroot and file is directly accessible relative to docroot
    if (getcwd() === __DIR__ && file_exists(getcwd() . $uri)) {
        return false;
    }

    // Otherwise serve directly with appropriate MIME type
    $mimeTypes = [
        'css'   => 'text/css',
        'js'    => 'application/javascript',
        'png'   => 'image/png',
        'jpg'   => 'image/jpeg',
        'jpeg'  => 'image/jpeg',
        'gif'   => 'image/gif',
        'svg'   => 'image/svg+xml',
        'webp'  => 'image/webp',
        'ico'   => 'image/x-icon',
        'woff'  => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf'   => 'font/ttf',
        'eot'   => 'application/vnd.ms-fontobject',
    ];

    $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
    $mime = $mimeTypes[$ext] ?? (function_exists('mime_content_type') ? mime_content_type($filePath) : 'application/octet-stream');

    header('Content-Type: ' . $mime);
    header('Content-Length: ' . filesize($filePath));
    readfile($filePath);
    exit;
}

require_once __DIR__ . '/index.php';
