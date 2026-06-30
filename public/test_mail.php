<?php
define('LARAVEL_ROOT', dirname(__DIR__));
require LARAVEL_ROOT . '/vendor/autoload.php';
$app = require_once LARAVEL_ROOT . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    Illuminate\Support\Facades\Mail::raw('Test email from The Sprout Academy live server.', function ($msg) {
        $msg->to('huzaifaalam36@gmail.com')
            ->subject('Mail Test - The Sprout Academy');
    });
    echo "✅ Mail sent successfully!";
} catch (\Exception $e) {
    echo "❌ Mail failed: " . $e->getMessage();
}
