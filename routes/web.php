<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\logoutController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\PageController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;


// ─── Default ────────────────────────────────────────────────

Route::view('/', 'login')->name('login');

Route::get('/notice', function () {
    return view('notice');
});


Route::get('/pages', function () {
    return view('pages');
});




// ─── Auth (Register / Login / Logout) ───────────────────────
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [LoginController::class, 'showLogin']);
Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', [logoutController::class, 'logout'])->name('logout');


// ─── User ────────────────────────────────────────────────────
Route::get('/user/profile/{id}', [LoginController::class, 'show'])->middleware('auth');


// ─── Dashboard ───────────────────────────────────────────────
Route::get('/dashboard', [CrudController::class, 'index'])->middleware('auth');


// ─── Tasks ───────────────────────────────────────────────────
// Route::post('/tasks', [CrudController::class, 'store']);
// Route::put('/tasks/{id}', [CrudController::class, 'update'])->name('tasks.update');
Route::delete('/dashboard/{id}', [CrudController::class, 'destroy'])->name('tasks.destroy');



Route::post('/tasks', [CrudController::class, 'store']);          // ← separate
Route::put('/tasks/{id}', [CrudController::class, 'update']);
Route::delete('/tasks/{id}', [CrudController::class, 'destroy']);

// ─── Notes ───────────────────────────────────────────────────
Route::post('/dashboard', [NoteController::class, 'store']);
Route::put('/notes/{id}', [NoteController::class,'update' ])->name('notes.update');
Route::delete('/dashboard/{id}', [NoteController::class, 'destroy'])->name('notes.destroy');

//Pages----------
Route::post('/pages' , [PageController::class,'store']);
Route::get('/pages' , [PageController::class , 'index'])->middleware('auth');
Route::put('/pages/{id}', [PageController::class, 'update'])->name('pages.update');
Route::delete('/pages/{id}', [PageController::class, 'destroy'])->name('pages.destroy');