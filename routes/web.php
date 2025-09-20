<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ForgetPasswordManager;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnnounceController;
use App\Http\Controllers\EquipController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EquipLoanController;
use App\Http\Controllers\ItemController;

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
    return view('webpage');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('admin/home', [App\Http\Controllers\HomeController::class, 'adminHome'])->name('admin.home')->middleware('is_admin');
Route::get('forget-password',[App\Http\Controllers\ForgetPasswordManager::class,'forgetPassword'])->name('forget.password');
Route::post('forget-password',[App\Http\Controllers\ForgetPasswordManager::class,'forgetPasswordPost'])->name('forget.password.post');

Route::get('dashboard',[App\Http\Controllers\memberDashboardController::class,'index'])->name('dashboard');
//Route::get('admin/dashboard',[App\Http\Controllers\DashboardController::class,'adminDashboard'])->name('admin.dashboard')->middleware('is_admin');
Route::get('admin/dashboard',[App\Http\Controllers\DashboardController::class,'index'])->name('admin.dashboard')->middleware('is_admin');
//Route::get('admin/dashboard/add-announce',[App\Http\Controllers\DashboardController::class,'addAnnounce'])->name('admin.add-announce')->middleware('is_admin');

Route::get('admin/announcements/create', [AnnounceController::class, 'create'])->name('admin.add-announce')->middleware('is_admin');
Route::post('admin/announcements',[AnnounceController::class,'store'])->name('admin.announce-store')->middleware('is_admin');
Route::get('admin/announcements/{announcement}/edit',[AnnounceController::class,'edit'])->name('admin.edit-announce')->middleware('is_admin');
Route::put('admin/announcements/{announcement}',[AnnounceController::class,'update'])->name('admin.update-announce')->middleware('is_admin');
Route::delete('admin/announcements/{id}', [AnnounceController::class, 'destroy'])
    ->name('admin.delete-announce')
    ->middleware('is_admin');

Route::get('admin/equip', [EquipController::class, 'index'])->name('admin.equip')->middleware('is_admin');
Route::get('admin/equip/create', [EquipController::class, 'create'])->name('admin.add-equip')->middleware('is_admin');
Route::post('admin/equip',[EquipController::class,'store'])->name('admin.equip-store')->middleware('is_admin');
Route::get('admin/equip/{equip}/edit',[EquipController::class,'edit'])->name('admin.edit-equip')->middleware('is_admin');
Route::put('admin/equip/{equip}}',[EquipController::class,'update'])->name('admin.update-equip')->middleware('is_admin');
Route::delete('admin/equip/{id}', [EquipController::class, 'destroy'])
    ->name('admin.delete-equip')
    ->middleware('is_admin');

Route::get('admin/category', [CategoryController::class, 'index'])->name('admin.category')->middleware('is_admin');
Route::get('admin/category/create', [CategoryController::class, 'create'])->name('admin.add-category')->middleware('is_admin');
Route::post('admin/category',[CategoryController::class,'store'])->name('admin.category-store')->middleware('is_admin');
Route::get('admin/category/{category}/edit',[CategoryController::class,'edit'])->name('admin.edit-category')->middleware('is_admin');
Route::put('admin/category/{category}}',[CategoryController::class,'update'])->name('admin.update-category')->middleware('is_admin');
Route::delete('admin/category/{id}', [CategoryController::class, 'destroy'])
    ->name('admin.delete-category')
    ->middleware('is_admin');

    Route::get('equipLoan', [EquipLoanController::class, 'index'])->name('equipLoan');

Route::get('admin/item', [ItemController::class, 'index'])->name('admin.item')->middleware('is_admin');
Route::get('admin/item/create', [ItemController::class, 'create'])->name('admin.add-item')->middleware('is_admin');
Route::post('admin/item',[ItemController::class,'store'])->name('admin.item-store')->middleware('is_admin');
Route::get('admin/item/{item}/edit',[ItemController::class,'edit'])->name('admin.edit-item')->middleware('is_admin');
Route::put('admin/item/{item}',[ItemController::class,'update'])->name('admin.update-item')->middleware('is_admin');
// ใน routes/web.php
Route::post('admin/items/bulk-update', [ItemController::class, 'bulkUpdate'])->name('admin.items.bulk-update')->middleware('is_admin');
Route::delete('admin/item/{id}', [ItemController::class, 'destroy'])
    ->name('admin.delete-item')
    ->middleware('is_admin');