<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Reset password for olivia.harper@test.com
$email = 'olivia.harper@test.com';
$newPassword = '12345678';

$user = User::where('email', $email)->first();

if ($user) {
    $user->password_hash = Hash::make($newPassword);
    $user->must_change_password = false;
    $user->save();
    
    echo "Password reset successfully for {$email}\n";
    echo "New password: {$newPassword}\n";
} else {
    echo "User not found: {$email}\n";
}

