<?php
// IMPORTANT: Delete this file after setup is complete!

define('LARAVEL_ROOT', dirname(__DIR__));

echo "<pre style='font-family:monospace; background:#1a1a1a; color:#0f0; padding:20px;'>";
echo "=== The Sprout Academy - Server Setup ===\n\n";

// Check if vendor exists
if (!is_dir(LARAVEL_ROOT . '/vendor')) {
    echo "❌ vendor/ folder missing. Running composer install...\n";
    $output = [];
    exec('cd ' . LARAVEL_ROOT . ' && composer install --no-dev --optimize-autoloader 2>&1', $output);
    echo implode("\n", $output) . "\n";
} else {
    echo "✅ vendor/ folder exists\n";
}

// Bootstrap Laravel
require LARAVEL_ROOT . '/vendor/autoload.php';
$app = require_once LARAVEL_ROOT . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Run migrations
echo "\n--- Running Migrations ---\n";
Artisan::call('migrate', ['--force' => true]);
echo Artisan::output();

// Run seeders if needed
// Artisan::call('db:seed', ['--force' => true]);

// Cache config
echo "\n--- Caching Config ---\n";
Artisan::call('config:cache');
echo Artisan::output();

// Cache routes
echo "\n--- Caching Routes ---\n";
Artisan::call('route:cache');
echo Artisan::output();

// Cache views
echo "\n--- Caching Views ---\n";
Artisan::call('view:cache');
echo Artisan::output();

// Storage link
echo "\n--- Creating Storage Link ---\n";
Artisan::call('storage:link');
echo Artisan::output();

echo "\n✅ Setup Complete! DELETE this file now: public/setup.php\n";
echo "</pre>";
