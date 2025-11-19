<!-- resources/views/auth/logout.blade.php -->
<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

// Logout the user
Auth::logout();

// Clear all session data
Session::flush();

// Redirect to login page
header('Location: ' . route('login'));
exit;
?>
