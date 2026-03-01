<?php

// Test if Cloudinary can be initialized
require 'vendor/autoload.php';
require 'bootstrap/app.php';

$app = app();

try {
    $cloudinary = $app->make('CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary');
    echo "Cloudinary initialized successfully!\n";
    echo "Cloud Name: " . config('filesystems.disks.cloudinary.cloud.cloud_name') . "\n";
} catch (\Exception $e) {
    echo "Error initializing Cloudinary:\n";
    echo $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
