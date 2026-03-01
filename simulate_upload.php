<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

// create fake image file
// create temporary PNG 1x1
$tmp = sys_get_temp_dir().'/test.png';
$base64 = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGMAAQAABQABDQottAAAAABJRU5ErkJggg==';
file_put_contents($tmp, base64_decode($base64));

$request = Request::create('/moments/store', 'POST', [
    'title' => 'test',
    'description' => 'desc',
    'date' => '2026-03-02',
]);

// attach file
$uploaded = new UploadedFile($tmp, 'test.jpg', 'image/jpeg', null, true);
$request->files->set('image', $uploaded);

// create controller instance
$controller = new App\Http\Controllers\MomentController();

try {
    $response = $controller->store($request);
    echo "response: ";
    var_dump($response);
} catch (\Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
    echo $e->getFile() . ':' . $e->getLine() . "\n";
    echo $e->getTraceAsString();
}
