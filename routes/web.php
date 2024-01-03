<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PagesContoller;
use Illuminate\Support\Facades\Auth;

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


// Auth Functions
Route::get('/register', function () {
   $user=auth::check();
   if($user){
    return redirect()->route('dashboard'); 
   };
    return view('auth.register');
})->name('register');

Route::get('/', function () {
    $user=auth::check();
    if($user){
        return redirect()->route('dashboard'); 
       };
    return view('auth.login');
})->name('login');

Route::get('/login', function () {
    $user=auth::check();
    if($user){
        return redirect()->route('dashboard'); 
       };
    return view('auth.login');
})->name('login');


Route::get('/logout', [UserController:: class ,'logout'])->name('logout');
Route::post('/register', [UserController:: class ,'addUser'])->name('add-user');
Route::post('/login', [UserController:: class ,'LOGIN'])->name('add-user');


Route::get('/category', [PagesContoller:: class ,'category']);
Route::post('/category_post', [PagesContoller:: class ,'category_post']);

Route::get('/edit_category/{id}', [PagesContoller:: class ,'edit_category']);
Route::post('/category/delete_category/{id}', [PagesContoller:: class ,'delete_category']);


//================================ Gloabl AUTH Middlewearstart start from HERE=================//
Route::middleware(['auth'])->group(function () {
    



// Pages Work
Route::get('dashboard' ,[PagesContoller::class, 'dashboard'] )->name('dashboard');

// Users Profile

Route::get('user-profile' ,[UserController::class, 'UserProfile'] )->name('user-profile');
Route::get('users/user_info/{id}' ,[UserController::class, 'userInfo']);

Route::post('update_user_profile/{id}' ,[UserController::class, 'UpdateProfile'] )->name('update_user_profile');
Route::post('user_password_update' ,[UserController::class, 'user_password_update'] )->name('user_password_update');

//Users List (Admin Work)
Route::get('users' ,[UserController::class, 'users'] )->name('users');
Route::post('/users/status-user/{id}', [UserController::class, 'ChangeUserStatus'])->name('status-user');
Route::get('users/edit-user/{id}' ,[UserController::class, 'UserEdit'] )->name('edit-user');
Route::post('/users/delete-user/{id}', [UserController::class, 'UserDelete'])->name('delete-user');

Route::get('users/create' ,[UserController::class, 'UserCreate'] )->name('create-user');
Route::post('users/user_information' ,[UserController::class, 'user_information'] )->name('user_information');
Route::post('update_user_profile' ,[UserController::class, 'update_user_profile'] )->name('update_user_profile');



// Route::get('search' ,[ReportController::class, 'search'] )->name('search');
Route::get('reports' ,[ReportController::class, 'ReportView'] )->name('reports');
Route::get('single_report/{id}' ,[PagesContoller::class, 'SingleReportView'] )->name('single_report');
Route::get('reports/create' ,[ReportController::class, 'ReportCreate'] )->name('create-report');
Route::post('/reports/report_submit' ,[ReportController::class, 'ReportSubmit'] )->name('report_submit');
Route::get('reports/edit-report/{id}' ,[ReportController::class, 'ReportEdit'] )->name('edit-report');
Route::delete('/reports/delete-report/{id}', [ReportController::class, 'ReportDelete'])->name('delete-report');
Route::delete('/reports/delete-report-permanent/{id}', [ReportController::class, 'ReportDeletePermanent'])->name('delete-report-permanent');


Route::get('reports/report-undo-delete/{id}' ,[ReportController::class, 'ReportDeleteUndo'] )->name('report-undo-delete');

//claender
Route::get('/calender',[ReportController::class ,'calender'])->name('calender');


});

Route::get('mail',[ReportController::class ,'mail'])->name('mail');
    
//////=============== Gloabl AUTH Middlewearstart END HERE==========================\\\\