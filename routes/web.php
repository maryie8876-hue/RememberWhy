<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\PromiseController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\ReflectionController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('conversation')->group(function () {
    Route::get('/start', [ConversationController::class, 'start'])->name('conversation.start');
    Route::get('/', [ConversationController::class, 'index'])->name('conversation.index');
    Route::post('/', [ConversationController::class, 'store'])->name('conversation.store');
});

Route::prefix('promise')->group(function () {
    Route::get('/generate', [PromiseController::class, 'generate'])->name('promise.generate');
    Route::get('/{uuid}', [PromiseController::class, 'show'])->name('promise.show');
    Route::post('/{uuid}/seal', [PromiseController::class, 'seal'])->name('promise.seal');
    Route::post('/{uuid}/email', [PromiseController::class, 'saveEmail'])->name('promise.save-email');
});

Route::get('/reconnect/{uuid}', [ReminderController::class, 'show'])->name('reconnect.show');

Route::get('/reflection', [ReflectionController::class, 'index'])->name('reflection.index');
