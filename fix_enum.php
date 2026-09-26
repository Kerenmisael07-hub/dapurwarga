<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

Illuminate\Support\Facades\DB::statement("ALTER TABLE users MODIFY role ENUM('superadmin','admin','seller','layanan') NOT NULL DEFAULT 'seller'");

echo "Enum updated successfully!\n";
