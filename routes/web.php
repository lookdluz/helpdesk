<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketReplyController;
use App\Http\Controllers\DashboardController;

Route::middleware('auth')->group(function () {
    Route::get('/', fn()=>redirect()->route('tickets.index'));
    Route::resource('tickets', TicketController::class)->only(['index','create','store','show','update']);
    Route::post('tickets/{ticket}/reply', [TicketReplyController::class,'store'])->name('tickets.reply');
    Route::get('/admin/dashboard', DashboardController::class)->name('dashboard')->middleware('can:is-admin');
});