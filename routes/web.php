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
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\contactController;




Auth::routes(['verify' => true]);
Route::get('/protected-route', 'RegisterController@create')->middleware(['auth', 'verified']);

Route::get('/contactIndex',  [contactController::class, 'index']);

Route::get('contact', [contactController::class, 'showContactForm'])->name('contact.show');
Route::post('contact', [contactController::class, 'submitContactForm'])->name('contact.submit');

// Using Laravel's built-in email verification feature
Route::get('verify-email', function () {
    return redirect()->route('verification.notice');
})->name('verify-email');


//Must be Auth for normal use in categories of business and for maps
Route::controller(PostCategories::class)->middleware(['auth', 'verified', 'checkstatus'])->group(function () {
    Route::get('/categories/accounting', 'showAccountingCategories')->name('showAccountingCategories');
    Route::get('/categories/agriculture', 'showAgricultureCategories')->name('showAgricultureCategories');
    Route::get('/categories/construction', 'showConstructionCategories')->name('showConstructionCategories');
    Route::get('/categories/education', 'showEducationCategories')->name('showEducationCategories');
    Route::get('/categories/finance', 'showFinanceCategories')->name('showFinanceCategories');
    Route::get('/categories/retail', 'showRetailCategories')->name('showRetailCategories');
    Route::get('/categories/fashion', 'showFashionCategories')->name('showFashionCategories');
    Route::get('/categories/fashion-photography-studios', 'showFashionPhotographyStudiosCategories')->name('showFashionPhotographyStudiosCategories');
    Route::get('/categories/healthcare', 'showHealthcareCategories')->name('showHealthcareCategories');
    Route::get('/categories/information-technology', 'showInformationTechnologyCategories')->name('showInformationTechnologyCategories');
    Route::get('/categories/shopping-malls', 'showShoppingMallsCategories')->name('showShoppingMallsCategories');
    Route::get('/categories/trading-goods', 'showTradingGoodsCategories')->name('showTradingGoodsCategories');
    Route::get('/categories/consulting', 'showConsultingCategories')->name('showConsultingCategories');
    Route::get('/categories/barber-shops', 'showBarberShopsCategories')->name('showBarberShopsCategories');
    Route::get('/categories/fashion-consultancy', 'showFashionConsultancyCategories')->name('showFashionConsultancyCategories');
    Route::get('/categories/beauty-salon', 'showBeautySalonCategories')->name('showBeautySalonCategories');
    Route::get('/categories/logistics', 'showLogisticsCategories')->name('showLogisticsCategories');
    Route::get('/categories/sports', 'showSportsCategories')->name('showSportsCategories');
    Route::get('/categories/pets', 'showPetsCategories')->name('showPetsCategories');
    Route::get('/categories/Pharmaceuticals', 'showPharmaceuticalsCategories')->name('showPharmaceuticalsCategories');
    Route::get('/categories/entertainment', 'showEntertainmentCategories')->name('showEntertainmentCategories');
    Route::get('/categories/pattern-making-services', 'showPatternMakingServicesCategories')->name('showPatternMakingServicesCategories');
    Route::get('/categories/maintenance', 'showMaintenanceCategories')->name('showMaintenanceCategories');
    Route::get('/categories/automative', 'showAutomativeCategories')->name('showAutomativeCategories');
    Route::get('/categories/environmental', 'showEnvironmentalCategories')->name('showEnvironmentalCategories');
    Route::get('/categories/quick-service-restaurants', 'showQuickServiceRestaurantsCategories')->name('showQuickServiceRestaurantsCategories');
    Route::get('/categories/food-beverages', 'showFoodBeveragesCategories')->name('showFoodBeveragesCategories');
    Route::get('/categories/garment-manufacturing', 'showGarmentManufacturingCategories')->name('showGarmentManufacturingCategories');
    Route::get('/categories/fashion-events-management', 'showFashionEventsManagementCategories')->name('showFashionEventsManagementCategories');
    Route::get('/categories/retail-clothing-stores', 'showRetailClothingStoresCategories')->name('showRetailClothingStoresCategories');
    Route::get('/categories/fashion-design-studios', 'showFashionDesignStudiosCategories')->name('showFashionDesignStudiosCategories');
    Route::get('/categories/shoe-manufacturing', 'showShoeManufacturingCategories')->name('showShoeManufacturingCategories');
    Route::get('/categories/tailoring-and-alterations', 'showTailoringAndAlterationsCategories')->name('showTailoringAndAlterationsCategories');
    Route::get('/categories/fashion-accessories', 'showFashionAccessoriesCategories')->name('showFashionAccessoriesCategories');
    Route::get('/categories/boutiques', 'showBoutiquesCategories')->name('showBoutiquesCategories');
    Route::get('/categories/apparel-recycling-and-upcycling', 'showApparelRecyclingAndUpcyclingCategories')->name('showApparelRecyclingAndUpcyclingCategories');
    Route::get('/categories/apparel-exporters', 'showApparelExportersCategories')->name('showApparelExportersCategories');
    Route::get('/categories/coffee-shops', 'showCoffeeShopsCategories')->name('showCoffeeShopsCategories');
    Route::get('/categories/Automotive', 'showAutomotiveCategories')->name('showAutomotiveCategories');

    Route::get('/search-business-posts', 'showAccountingCategories')->name('searchBusinessPosts');

    Route::get('/business-post/{id}', 'show')->name('businessPost');

    // // Route to display a single business post
    // Route::get('/business/{id}', [ManagePostController::class, 'show'])->name('business.show');
    // Route::post('/categories/{category}/comments', 'CommentController@store')->name('comments.store');



        // Route to handle adding comments to a business post
        Route::post('/posts/{id}/comments', [CommentController::class, 'storeComment'])->name('comments.store');

        Route::post('/posts/{postId}/ratings', [RatingController::class, 'storeRating'])->name('ratings.store');


        // Route::post('/ratings/{postId}', [RatingController::class, 'store'])->name('ratings.store');

    // Route to display the search business
    Route::get('/search-categories', [SearchController::class, 'searchCategories'])->name('searchPosts');
    // Route to display the map page
    Route::get('/mapStore', [ListingController::class, 'mapStore'])->name('mapStore');


});


Route::controller(MessagesController::class)->middleware(['auth', 'checkstatus', 'verified'])->group(function () {
    Route::get('/chatify', 'index')->name('chatify');
    Route::get('/chatify/{id}', 'index')->name('chatify.id');
    Route::get('/chatify/user/{userId}', 'index')->name('chatify.user');
});


// Business Routes with Email Verification Middleware
Route::middleware(['auth', 'user-access:business', 'verified', 'checkstatus'])->group(function () {
    Route::get('/business/home', [HomeController::class, 'businessHome'])->name('business.home');
    Route::get('/business/home', [HomeController::class, 'businessPostList'])->name('business.home');

    // Define routes for listing creation
    Route::get('/listings/create', [ListingController::class, 'create'])->name('listings.create');
    Route::post('/listings', [ListingController::class, 'store'])->name('listings.store');



    // Route to add a maps
    Route::get('/map', [ListingController::class, 'map'])->name('map');
    // Route to add a maps
    Route::get('/mapAdmin', [ManagePostController::class, 'mapAdmin'])->name('mapAdmin');

});




// Normal Users Routes with Email Verification Middleware
Route::middleware(['auth', 'user-access:user', 'verified'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/home', [HomeController::class, 'businessPostListForUser'])->name('home');
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
        Route::post('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

        // Route::delete('notifications/{id}', [HomeController::class, 'deleteNotification'])->name('notifications.delete');
        // Route::get('/mark-as-read', [App\Http\Controllers\HomeController::class,'markAsRead'])->name('mark-as-read');
        // Route::delete('/notifications', [HomeController::class, 'deleteAllNotifications'])->name('notifications.deleteAll');


        Route::delete('notifications/{id}', [HomeController::class, 'deleteNotification'])->name('notifications.delete');
        Route::get('/mark-as-read', [HomeController::class, 'markAsRead'])->name('mark-as-read');
        Route::delete('/notifications', [HomeController::class, 'deleteAllNotifications'])->name('notifications.deleteAll');




        Route::get('/main', [App\Http\Controllers\HomeController::class, 'index'])->name('main');
        Route::get('ManagePost', [App\Http\Controllers\ManagePostController::class, 'index'])->name('ManagePost');
        Route::get('ManagePost', [App\Http\Controllers\ManagePostController::class, 'sortTable'])->name('ManagePost');
        Route::get('/ManagePost/create', [ManagePostController::class, 'create'])->name('managepost.create');
        Route::post('/ManagePost', [ManagePostController::class, 'store'])->name('managepost.store');



        // Route::get('ManagePost/create',[App\Http\Controllers\ManagePostController::class, 'create']);
        // Route::post('ManagePost/create', [App\Http\Controllers\ManagePostController::class, 'store']);
        Route::get('ManagePost/{id}/edit', [App\Http\Controllers\ManagePostController::class, 'edit']);
        Route::put('ManagePost/{id}/edit', [App\Http\Controllers\ManagePostController::class, 'update']);
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
