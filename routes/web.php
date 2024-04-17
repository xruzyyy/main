<?php

use App\Http\Controllers\ManagePostController;
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
use App\Http\Controllers\vendor\Chatify\MessagesController;
use App\Http\Controllers\PostCategories;



Auth::routes(['verify' => true]);
Route::get('/protected-route', 'RegisterController@create')->middleware(['auth', 'verified']);


//Must be Auth for normal use in categories of business and for maps
Route::middleware(['auth'])->group(function () {
    Route::get('/categories/accounting', [PostCategories::class, 'showAccountingCategories'])->name('showAccountingCategories');
    Route::get('/categories/agriculture', [PostCategories::class, 'showAgricultureCategories'])->name('showAgricultureCategories');
    Route::get('/categories/construction', [PostCategories::class, 'showConstructionCategories'])->name('showConstructionCategories');
    Route::get('/categories/education', [PostCategories::class, 'showEducationCategories'])->name('showEducationCategories');
    Route::get('/categories/finance', [PostCategories::class, 'showFinanceCategories'])->name('showFinanceCategories');
    Route::get('/categories/retail', [PostCategories::class, 'showRetailCategories'])->name('showRetailCategories');
    Route::get('/categories/fashion', [PostCategories::class, 'showFashionCategories'])->name('showFashionCategories');
    Route::get('/categories/fashion-photography-studios', [PostCategories::class, 'showFashionPhotographyStudiosCategories'])->name('showFashionPhotographyStudiosCategories');
    Route::get('/categories/healthcare', [PostCategories::class, 'showHealthcareCategories'])->name('showHealthcareCategories');
    Route::get('/categories/information-technology', [PostCategories::class, 'showInformationTechnologyCategories'])->name('showInformationTechnologyCategories');
    Route::get('/categories/shopping-malls', [PostCategories::class, 'showShoppingMallsCategories'])->name('showShoppingMallsCategories');
    Route::get('/categories/trading-goods', [PostCategories::class, 'showTradingGoodsCategories'])->name('showTradingGoodsCategories');
    Route::get('/categories/consulting', [PostCategories::class, 'showConsultingCategories'])->name('showConsultingCategories');
    Route::get('/categories/barber-shops', [PostCategories::class, 'showBarberShopsCategories'])->name('showBarberShopsCategories');
    Route::get('/categories/fashion-consultancy', [PostCategories::class, 'showFashionConsultancyCategories'])->name('showFashionConsultancyCategories');
    Route::get('/categories/beauty-salon', [PostCategories::class, 'showBeautySalonCategories'])->name('showBeautySalonCategories');
    Route::get('/categories/logistics', [PostCategories::class, 'showLogisticsCategories'])->name('showLogisticsCategories');
    Route::get('/categories/sports', [PostCategories::class, 'showSportsCategories'])->name('showSportsCategories');
    Route::get('/categories/pets', [PostCategories::class, 'showPetsCategories'])->name('showPetsCategories');
    Route::get('/categories/Pharmaceuticals', [PostCategories::class, 'showPharmaceuticalsCategories'])->name('showPharmaceuticalsCategories');
    Route::get('/categories/entertainment', [PostCategories::class, 'showEntertainmentCategories'])->name('showEntertainmentCategories');
    Route::get('/categories/pattern-making-services', [PostCategories::class, 'showPatternMakingServicesCategories'])->name('showPatternMakingServicesCategories');
    Route::get('/categories/maintenance', [PostCategories::class, 'showMaintenanceCategories'])->name('showMaintenanceCategories');
    Route::get('/categories/automative', [PostCategories::class, 'showAutomativeCategories'])->name('showAutomativeCategories');
    Route::get('/categories/environmental', [PostCategories::class, 'showEnvironmentalCategories'])->name('showEnvironmentalCategories');
    Route::get('/categories/food-beverages', [PostCategories::class, 'showFoodBeveragesCategories'])->name('showFoodBeveragesCategories');
    Route::get('/categories/garment-manufacturing', [PostCategories::class, 'showGarmentManufacturingCategories'])->name('showGarmentManufacturingCategories');
    Route::get('/categories/fashion-events-management', [PostCategories::class, 'showFashionEventsManagementCategories'])->name('showFashionEventsManagementCategories');
    Route::get('/categories/retail-clothing-stores', [PostCategories::class, 'showRetailClothingStoresCategories'])->name('showRetailClothingStoresCategories');
    Route::get('/categories/fashion-design-studios', [PostCategories::class, 'showFashionDesignStudiosCategories'])->name('showFashionDesignStudiosCategories');
    Route::get('/categories/shoe-manufacturing', [PostCategories::class, 'showShoeManufacturingCategories'])->name('showShoeManufacturingCategories');
    Route::get('/categories/tailoring-and-alterations', [PostCategories::class, 'showTailoringAndAlterationsCategories'])->name('showTailoringAndAlterationsCategories');
    Route::get('/categories/textile-printing-and-embroidery', [PostCategories::class, 'showTextilePrintingAndEmbroideryCategories'])->name('showTextilePrintingAndEmbroideryCategories');
    Route::get('/categories/fashion-accessories', [PostCategories::class, 'showFashionAccessoriesCategories'])->name('showFashionAccessoriesCategories');
    Route::get('/categories/boutiques', [PostCategories::class, 'showBoutiquesCategories'])->name('showBoutiquesCategories');
    Route::get('/categories/apparel-recycling-and-upcycling', [PostCategories::class, 'showApparelRecyclingAndUpcyclingCategories'])->name('showApparelRecyclingAndUpcyclingCategories');
    Route::get('/categories/apparel-exporters', [PostCategories::class, 'showApparelExportersCategories'])->name('showApparelExportersCategories');
    Route::get('/categories/coffee-shops', [PostCategories::class, 'showCoffeeShopsCategories'])->name('showCoffeeShopsCategories');
    Route::get('/categories/Automotive', [PostCategories::class, 'showAutomotiveCategories'])->name('showAutomotiveCategories');





    // Route to display the map page
Route::get('/mapStore', [ListingController::class, 'mapStore'])->name('mapStore');
});




Route::get('/chatify/{id}', [MessagesController::class, 'index'])->name('chatify.id')->middleware(['auth', 'verified']);
Route::get('/chatify/user/{userId}', 'MessagesController@index')->name('chatify.user')->middleware(['auth', 'verified']);


// Business Routes with Email Verification Middleware
Route::middleware(['auth', 'user-access:business', 'verified','checkstatus'])->group(function () {
    Route::get('/business/home', [HomeController::class, 'businessHome'])-> name('business.home');
    Route::get('/business/home', [HomeController::class, 'businessPostList'])-> name('business.home');

    // Define routes for listing creation
Route::get('/listings/create', [ListingController::class, 'create'])->name('listings.create');
Route::post('/listings', [ListingController::class, 'store'])->name('listings.store');



// Route to add a maps
Route::get('/map', [ListingController::class, 'map'])->name('map');


});




// Normal Users Routes with Email Verification Middleware
Route::middleware(['auth', 'user-access:user', 'verified'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/home', [HomeController::class, 'businessPostListForUser'])-> name('home');


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
    Route::get('ManagePost', [App\Http\Controllers\ManagePostController::class, 'index'])->name('ManagePost');
    Route::get('ManagePost', [App\Http\Controllers\ManagePostController::class, 'sortTable'])->name('ManagePost');


    Route::get('ManagePost/create',[App\Http\Controllers\ManagePostController::class, 'create']);
    Route::post('ManagePost/create', [App\Http\Controllers\ManagePostController::class, 'store']);
    Route::get('ManagePost/{id}/edit',[App\Http\Controllers\ManagePostController::class, 'edit']);
    Route::put('ManagePost/{id}/edit',[App\Http\Controllers\ManagePostController::class, 'update']);
    Route::delete('ManagePost/{id}/delete', [ManagePostController::class, 'destroy']);
    Route::get('ManagePost/{id}/toggleStatus', [ManagePostController::class, 'toggleStatus'])->name('ManagePost.toggleStatus');

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






