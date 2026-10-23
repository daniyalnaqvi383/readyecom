<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

// Create dummy uploaded file
$tmpFile = tempnam(sys_get_temp_dir(), 'test_upload');
file_put_contents($tmpFile, 'fake image data');
$uploadedFile = new UploadedFile($tmpFile, 'test.png', 'image/png', null, true);

echo "Testing putFile...\n";
try {
    $res = Storage::disk('public')->putFile('test_folder', $uploadedFile);
    echo "SUCCESS: stored at: " . $res . "\n";
    Storage::disk('public')->delete($res);
} catch (\Throwable $e) {
    echo "ERROR with putFile: " . $e->getMessage() . "\n";
}

echo "Testing put(path, UploadedFile)...\n";
try {
    $uploadedFile2 = new UploadedFile($tmpFile, 'test2.png', 'image/png', null, true);
    $res2 = Storage::disk('public')->put('/test_folder', $uploadedFile2);
    echo "Result with put: " . var_export($res2, true) . "\n";
} catch (\Throwable $e) {
    echo "ERROR with put: " . $e->getMessage() . "\n";
}

@unlink($tmpFile);
