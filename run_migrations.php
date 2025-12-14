<?php

use Illuminate\Contracts\Console\Kernel;

require __DIR__ . '/vendor/autoload.php';

// Bootstrap the Laravel application
$app = require_once __DIR__ . '/bootstrap/app.php';

/** @var Kernel $kernel */
$kernel = $app->make(Kernel::class);

try {
    // Run all pending migrations with --force
    $kernel->call('migrate', ['--force' => true]);

    echo "✅ All pending migrations executed successfully.\n";
} catch (\Exception $e) {
    echo "❌ Migration failed: " . $e->getMessage() . "\n";
}
