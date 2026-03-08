<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Kopou\SESEngine\Services\SesMailer;
use Kopou\SESEngine\Models\Suppression;

Route::get('/test-ses', function () {

    $mailer = new SesMailer();
    $to = 'rajiv@webguy.in';
    if (Suppression::isSuppressed($to)) {
        return [
            'status' => 'blocked',
            'reason' => 'email is suppressed'
        ];
    }
    $mailer->send(
        $to,
        'Test from KopouSESEngine',
        '<h1>Hello from SES Engine</h1>',
        'hello@discover.northeastexplorers.com',
        'marketing'
    );

    return "Sent!";
})->name('test-ses');
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
