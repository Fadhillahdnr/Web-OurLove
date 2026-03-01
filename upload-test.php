<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    // upload 1x1 transparent PNG using data URI
    $base64 = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGMAAQAABQABDQottAAAAABJRU5ErkJggg==';
    $res = cloudinary()->uploadApi()->upload($base64, [
        'folder' => 'love-website/test',
        'transformation' => ['quality' => 'auto'],
    ]);
    echo "upload succeeded\n";
    var_dump($res);
} catch (\Exception $e) {
    echo "upload error: " . $e->getMessage() . "\n";
    echo "trace:\n" . $e->getTraceAsString();
}
