<?php

use Illuminate\Support\Facades\Route;
use Kopou\SESEngine\Http\Controllers\TrackingController;
use Kopou\SESEngine\Http\Controllers\SesWebhookController;

Route::post('/kopou/ses/webhook', [SesWebhookController::class, 'handle']);

Route::get('/kopou/track/open/{messageId}', [TrackingController::class, 'open']);

Route::get('/kopou/track/click/{messageId}', [TrackingController::class, 'click']);
