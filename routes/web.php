<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/admin', [UserController::class, 'index'])->name('admin');
    Route::get('/admin/user/{id}', [UserController::class, 'show'])->name('admin.user.show');
    Route::put('/admin/user/{id}', [UserController::class, 'edit'])->name('admin.user.edit');
    Route::delete('/admin/user/{id}', [UserController::class, 'delete'])->name('admin.user.delete');
});
