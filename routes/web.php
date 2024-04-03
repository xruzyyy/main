<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ManageBusinessController;
use App\Http\Middleware\CheckStatus;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ListingController;


Auth::routes(['verify' => true]);
Route::get('/protected-route', 'RegisterController@create')->middleware(['auth', 'verified']);




// Business Routes with Email Verification Middleware
Route::middleware(['auth', 'user-access:business', 'verified','checkstatus'])->group(function () {
    Route::get('/business/home', [HomeController::class, 'businessHome'])-> name('business.home');
    
    // Define routes for listing creation
Route::get('/listings/create', [ListingController::class, 'create'])->name('listings.create');
Route::post('/listings', [ListingController::class, 'store'])->name('listings.store');




// Route to display the map page
Route::get('/map', [ListingController::class, 'map'])->name('map');
});

// Normal Users Routes with Email Verification Middleware
Route::middleware(['auth', 'user-access:user', 'verified'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});


// Admin Routes
Route::middleware(['auth', 'user-access:admin'])->group(function () {
    Route::get('/admin/dashboard', [HomeController::class, 'adminDashboard'])->name('admin.dashboard');

    
// Middleware group for authenticated users
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', function () {
        return redirect()->route('main');
    })->name('main');
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/home', [App\Http\Controllers\HomeController::class,'index'])->name('home');
    
    // Route::delete('notifications/{id}', [HomeController::class, 'deleteNotification'])->name('notifications.delete');
    // Route::get('/mark-as-read', [App\Http\Controllers\HomeController::class,'markAsRead'])->name('mark-as-read');
    // Route::delete('/notifications', [HomeController::class, 'deleteAllNotifications'])->name('notifications.deleteAll');


    Route::delete('notifications/{id}', [HomeController::class, 'deleteNotification'])->name('notifications.delete');
    Route::get('/mark-as-read', [HomeController::class,'markAsRead'])->name('mark-as-read');
    Route::delete('/notifications', [HomeController::class, 'deleteAllNotifications'])->name('notifications.deleteAll');
    



    Route::get('/main', [App\Http\Controllers\HomeController::class, 'index'])->name('main');
    Route::get('categories', [App\Http\Controllers\CategoryController::class, 'index'])->name('categories');    
    Route::get('categories', [App\Http\Controllers\CategoryController::class, 'sortTable'])->name('categories');   

    
    Route::get('categories/create',[App\Http\Controllers\CategoryController::class, 'create']);
    Route::post('categories/create', [App\Http\Controllers\CategoryController::class, 'store']);
    Route::get('categories/{id}/edit',[App\Http\Controllers\CategoryController::class, 'edit']);
    Route::put('categories/{id}/edit',[App\Http\Controllers\CategoryController::class, 'update']);
    Route::delete('categories/{id}/delete', [CategoryController::class, 'destroy']);
    Route::get('categories/{id}/toggleStatus', [CategoryController::class, 'toggleStatus'])->name('categories.toggleStatus');

    Route::get('/usersList', [UserController::class, 'index'])->name('users');
    Route::get('/user{id}', [UserController::class, 'update']);
    Route::get('/users/{user}/toggleStatus', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
    

        // Route for displaying the form to create a new user
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');

    // Route for handling the creation of a new user
    Route::post('/users', [UserController::class, 'store'])->name('users.store');

    // Route for displaying the form to edit an existing user
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');

    // Route for updating an existing user
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');

    // Route for deleting an existing user
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');


    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('users/store', [UserController::class, 'store'])->name('users.store');
    Route::get('users/{userId}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{userId}/update', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{userId}/delete', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('users/{userId}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
    Route::get('users/sort', [UserController::class, 'sortTable'])->name('users.sortTable');

    // Route::match(['get', 'post'], '/run-schedule', [ScheduleController::class, 'runSchedule']);
    // Route::get('/run-schedule', [ScheduleController::class, 'showScheduleForm'])->name('run-schedule-form');


    Route::get('admin/ManageBusiness', [HomeController::class, 'adminManageBusiness'])->name('admin.ManageBusiness');


    Route::get('/ManageBusiness', [ManageBusinessController::class, 'ManageBusinessForm'])->name('manageBusinessForm');
    Route::post('/ManageBusiness', [ManageBusinessController::class, 'ManageBusiness'])->name('manageBusiness');





});


});






