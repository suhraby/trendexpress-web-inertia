<?php

use App\Http\Controllers\TelegramBotController;
use Illuminate\Support\Facades\Route;

Route::get('test', function () {
    return response()->json(['message' => 'Success'], 200);
});

Route::prefix('telegram')->name('telegram.')->group(function () {
    Route::post('webhook', [TelegramBotController::class, 'webhook'])->name('webhook');

    Route::middleware(['telegram.admin'])->group(function () {
        Route::get('set-webhook', [TelegramBotController::class, 'setWebhook'])->name('set-webhook');
        Route::get('remove-webhook', [TelegramBotController::class, 'removeWebhook'])->name('remove-webhook');
        Route::get('webhook-info', [TelegramBotController::class, 'getWebhookInfo'])->name('webhook-info');

        Route::get('set-commands', [TelegramBotController::class, 'setBotCommands'])->name('set-commands');
        Route::get('get-commands', [TelegramBotController::class, 'getBotCommands'])->name('get-commands');
        Route::get('delete-commands', [TelegramBotController::class, 'deleteBotCommands'])->name('delete-commands');
    });
});
