<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
//Auth Routes
Auth::routes();
Route::get('/profile/{username}', [App\Http\Controllers\AuthenticatedUsers::class, 'profile'])->name('profile');


//Guest routes
Route::get('/', [App\Http\Controllers\Guest::class, 'home'])->name('home');
Route::get('/work', [App\Http\Controllers\Guest::class, 'work'])->name('work');
Route::get('/contact', [App\Http\Controllers\Guest::class, 'contact'])->name('contact');
Route::get('/password-reset', [App\Http\Controllers\Guest::class, 'passwordreset'])->name('passwordreset')->middleware('guest');
Route::post('/password-reset', [App\Http\Controllers\Guest::class, 'passwordreset_email'])->name('passwordreset_email')->middleware('guest');
Route::get('/password-recover', [App\Http\Controllers\Guest::class, 'password_recover'])->name('password_recover')->middleware('guest');
Route::post('/password-recover/{email}', [App\Http\Controllers\Guest::class, 'password_recover_post'])->name('password_recover_post')->middleware('guest');


//Admin Routes
Route::get('/admin/control-panel', [App\Http\Controllers\AdminController::class, 'control_panel'])->name('control_panel');
Route::get('/admin/edit-register/{id}', [App\Http\Controllers\AdminController::class, 'edit_register'])->name('edit_register');
Route::post('/admin/update-register', [App\Http\Controllers\AdminController::class, 'update_register'])->name('update_register');
Route::get('/admin/show-delete-form/{id}', [App\Http\Controllers\AdminController::class, 'showdeletemodal'])->name('show_delete_form');
Route::post('/admin/delete-register/', [App\Http\Controllers\AdminController::class, 'delete_register'])->name('delete_register');
Route::get('/admin/edit-users/{id}', [App\Http\Controllers\AdminController::class, 'edit_users'])->name('edit_users');
Route::post('/admin/add-users', [App\Http\Controllers\AdminController::class, 'add_users'])->name('add_users');
