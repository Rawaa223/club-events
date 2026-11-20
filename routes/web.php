<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('events.index'))->name('home');

// JSON list (run `php artisan route:list` to see every named route)
Route::get('/api/events', [EventController::class, 'json'])->name('events.json');

// events.index, events.create, events.store, events.show, events.edit, events.update, events.destroy
Route::resource('events', EventController::class);

// members.index, members.show
Route::resource('members', MemberController::class)->only(['index', 'show']);
