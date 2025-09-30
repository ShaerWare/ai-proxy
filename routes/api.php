<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ChatController;

Route::prefix('v1')->group(function () {
    Route::post('/chat', [ChatController::class, 'handle']);
});
