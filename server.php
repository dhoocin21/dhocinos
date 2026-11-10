<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * This server.php script enables built-in PHP web server (php artisan serve)
 * to seamlessly serve static files from storage/app/public without requiring symlinks.
 * This is crucial for Android (Termux) and shared environments where symlinks are restricted.
 */

$publicPath = __DIR__.'/public';

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? ''
);

// Serve /storage/... directly from storage/app/public if it exists
if (str_starts_with($uri, '/storage/')) {
    $storageRelative = substr($uri, 9); // Remove '/storage/'
    $storageFile = __DIR__.'/storage/app/public/'.$storageRelative;
    
    if (file_exists($storageFile) && !is_dir($storageFile)) {
        $mimeTypes = [
            'png'  => 'image/png',
            'jpg'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'webp' => 'image/webp',
            'svg'  => 'image/svg+xml',
            'gif'  => 'image/gif',
            'pdf'  => 'application/pdf',
            'mp4'  => 'video/mp4',
        ];
        $ext = strtolower(pathinfo($storageFile, PATHINFO_EXTENSION));
        $contentType = $mimeTypes[$ext] ?? mime_content_type($storageFile) ?: 'application/octet-stream';
        
        header('Content-Type: '.$contentType);
        header('Content-Length: '.filesize($storageFile));
        header('Cache-Control: public, max-age=31536000');
        readfile($storageFile);
        exit;
    }
}

// Emulate Apache "mod_rewrite" functionality
if ($uri !== '/' && file_exists($publicPath.$uri)) {
    return false;
}

require_once $publicPath.'/index.php';
