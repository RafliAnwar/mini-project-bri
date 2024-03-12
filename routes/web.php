<?php

use App\Http\Controllers\AccessController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\GradeController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('admin.auth.login');
});

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/auth/login', [LoginController::class, 'authenticate'])->name('login.auth');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/access', [AccessController::class, 'access'])->name('access');

Route::group(['prefix' => 'admin', 'middleware' => ['user.auth']], function () {
    //dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::group(['middleware' => ['user.acc:admin']], function () {
        //subject
        Route::group(['prefix' => 'subject'], function () {
            Route::get('/', [SubjectController::class, 'index'])->name('admin.subject');
            Route::get('/create', [SubjectController::class, 'create'])->name('admin.subject.create');
            Route::post('/store', [SubjectController::class, 'store'])->name('admin.subject.store');
            Route::get('/edit/{id}', [SubjectController::class, 'edit'])->name('admin.subject.edit');
            Route::put('/update/{id}', [SubjectController::class, 'update'])->name('admin.subject.update');
            Route::delete('/destroy/{id}', [SubjectController::class, 'destroy'])->name('admin.subject.destroy');
        });
        //grades
        Route::group(['prefix' => 'grade'], function () {
            Route::get('/', [GradeController::class, 'index'])->name('admin.grade');
            Route::get('/create', [GradeController::class, 'create'])->name('admin.grade.create');
            Route::post('/store', [GradeController::class, 'store'])->name('admin.grade.store');
            Route::get('/edit/{id}', [GradeController::class, 'edit'])->name('admin.grade.edit');
            Route::put('/update/{id}', [GradeController::class, 'update'])->name('admin.grade.update');
            Route::delete('/destroy/{id}', [GradeController::class, 'destroy'])->name('admin.grade.destroy');
        });
        //users
        Route::group(['prefix' => 'user'], function () {
            Route::get('/', [UserController::class, 'index'])->name('admin.user');
            Route::get('/create', [UserController::class, 'create'])->name('admin.user.create');
            Route::post('/store', [UserController::class, 'store'])->name('admin.user.store');
            Route::get('/edit/{id}', [UserController::class, 'edit'])->name('admin.user.edit');
            Route::put('/update/{id}', [UserController::class, 'update'])->name('admin.user.update');
            Route::delete('/destroy/{id}', [UserController::class, 'destroy'])->name('admin.user.destroy');
        });
    });
    //codes

    //attendances


});
