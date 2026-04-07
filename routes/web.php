<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\logoutController;
use Illuminate\Support\Facades\Route;



// Route::view('/', 'welcome')->name('home');
Route::view('/', 'login')->name('login');



Route::get('/register', [AuthController::class, 'showRegister']); //show the 
Route::post('/register', [AuthController::class, 'register']);
//        action in the form, class,               method


//show login
Route::get('/login', [LoginController::class, 'showLogin']); 

Route::post('/login', [LoginController::class, 'login']);

//logut
Route::post('/logout', [logoutController::class, 'logout'])->name('logout');


//show user name
Route::get('/user/profile/{id} ', [LoginController::class, 'show']);

//show db
Route::get('/dashboard', [DashboardController::class, 'showDashboard']); //show the 


//task
Route::post('/dashboard', [CrudController::class, 'store']);


//redirect for login
Route::get('/notice', function () {
    return view('notice'); 
});


//show the task
Route::get('/dashboard', [CrudController::class, 'index'])->name('dashboard');

Route::put('/tasks/{id}', [CrudController::class, 'update'])->name('tasks.update');

