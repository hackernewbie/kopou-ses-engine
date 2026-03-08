<?php

use Illuminate\Support\Facades\Route;
use Kopou\SESEngine\Http\Controllers\SesWebhookController;

Route::post('/kopou/ses/webhook', [SesWebhookController::class, 'handle']);
