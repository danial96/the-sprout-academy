<?php
define('LARAVEL_ROOT', dirname(__DIR__));
require LARAVEL_ROOT . '/vendor/autoload.php';
$app = require_once LARAVEL_ROOT . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

Artisan::call('db:seed', ['--class' => 'AdminUserSeeder', '--force' => true]);
echo Artisan::output();
echo "Done!";
