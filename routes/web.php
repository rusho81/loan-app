<?php

use App\Http\Controllers\Backend\Admin\LoanController;
use App\Http\Controllers\Backend\Admin\LoanTypesController;
use App\Http\Controllers\Backend\Admin\UsersController;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\ProfileController;
use App\Models\LoanApplication;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth','role:admin'])->group(function(){
    Route::get('/admin/dashboard',[AdminController::class, 'index'])->name('admin.dashboard');

    Route::get('/admin/profile',[AdminController::class, 'profile'])->name('admin.profile');
    Route::post('/admin/update/profile',[AdminController::class, 'updateProfile'])->name('admin.profile.update');
    Route::get('/admin/update/password',[AdminController::class, 'updatePassword'])->name('admin.password.update');
    Route::post('/admin/store/password',[AdminController::class, 'storePassword'])->name('admin.password.store');

    Route::get('/admin/all/users',[UsersController::class, 'allUsers'])->name('admin.all.users');
    Route::delete('admin/delete/{user}', [UsersController::class, 'deleteUser'])->name('delete.user');
    Route::get('admin/user/detail/{user}', [UsersController::class, 'userDetail'])->name('user.detail');

    Route::post('admin/user/{id}/toggle-user', [UsersController::class, 'toggleRole'])->name('user.toggle-role');
    Route::post('admin/user/{id}/toggle-status', [UsersController::class, 'toggleStatus'])->name('user.toggle-status');

    Route::get('/admin/all/loan/types',[LoanTypesController::class, 'allLoanTypes'])->name('admin.all.loan.types');
    Route::post('/admin/add/loan_types',[LoanTypesController::class, 'addLoanTypes'])->name('admin.add.loan.types');
    Route::delete('admin/delete/loan_type/{loan_type}', [LoanTypesController::class, 'deleteLoanType'])->name('user.loan_type');
    Route::get('/admin/loan-types/{id}/edit',[LoanTypesController::class, 'editLoanTypes'])->name('admin.edit.loan.types');
    Route::put('/admin/loan-types/{id}',[LoanTypesController::class, 'updateLoanTypes'])->name('admin.update.loan.types');

    Route::get('/admin/all/loan/applications',[LoanController::class, 'allLoanApplications'])->name('admin.all.loan.applications');
});
Route::middleware(['auth','role:user'])->group(function(){
    Route::get('/user/dashboard',[UserController::class, 'index'])->name('user.dashboard');
    Route::get('/user/profile',[UserController::class, 'profile'])->name('user.profile');
    Route::post('/user/update/profile',[UserController::class, 'updateProfile'])->name('user.profile.update');
    Route::get('/user/update/password',[UserController::class, 'updatePassword'])->name('user.password.update');
    Route::post('/user/store/password',[UserController::class, 'storePassword'])->name('user.password.store');
    Route::get('/user/loan/application',[LoanController::class, 'loanApplication'])->name('user.loan.application');
});

require __DIR__.'/auth.php';
