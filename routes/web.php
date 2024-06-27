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
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Business\BusinessProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\UpdateAccountController;







Auth::routes(['verify' => true]);
// Route::get('/protected-route', 'RegisterController@create')->middleware(['auth', 'verified']);
// web.php

Route::post('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

Route::middleware(['auth','user-access:business'])->group(function () {
    Route::get('/update_account_details', [UpdateAccountController::class, 'showUpdateForm'])->name('update_account_details');
    Route::post('/update_account_details', [UpdateAccountController::class, 'storeAccountUpdate'])->name('post_update_account_details');
});


// // Route for root URL redirection based on user type
// Route::middleware('auth')->get('/', function () {
//     $userType = auth()->user()->type;

//     if ($userType == 'user') {
//         return redirect('/home');
//     } elseif ($userType == 'business') {
//         return redirect('/business/home');
//     }

//     // For any other case, handle as per your application's logic
//     abort(403, 'Unauthorized action.');
// });

// Route for root URL redirection based on user type
Route::middleware('auth')->get('/', function () {
    $userType = auth()->user()->type;

    switch ($userType) {
        case 'user':
            return redirect('/home');
        case 'business':
            return redirect('/business/home');
        case 'admin':
            // Handle admin redirection or logic here, if needed
            return redirect('/admin/dashboard');
        default:
            abort(403, 'Unauthorized action.');
    }
});



// Using Laravel's built-in email verification feature
Route::get('verify-email', function () {
    return redirect()->route('verification.notice');
})->name('verify-email');


Route::controller(MessagesController::class)->middleware(['auth', 'checkstatus', 'verified'])->group(function () {
    Route::get('/chatify', 'index')->name('chatify');
    Route::get('/chatify/{id}', 'index')->name('chatify.id');
    Route::get('/chatify/user/{userId}', 'index')->name('chatify.user');
});

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



    // Route to handle adding comments to a business post
    Route::post('/posts/{id}/comments', [CommentController::class, 'storeComment'])->name('comments.store');

    Route::post('/posts/{postId}/ratings', [RatingController::class, 'storeRating'])->name('ratings.store');



    // Route to display the search business
    Route::get('/search-categories', [SearchController::class, 'searchCategories'])->name('searchPosts');
    // Route to display the map page
    Route::get('/mapStore', [HomeController::class, 'mapStore'])->name('mapStore');



    Route::get('contact', [contactController::class, 'showContactForm'])->name('contact.show');
    Route::post('contact', [contactController::class, 'submitContactForm'])->name('contact.submit');

    Route::get('/notifications', [NotificationController::class, 'getUserProfile'])->name('notifications.index');
});




// Business Routes with Email Verification Middleware
Route::middleware(['auth', 'user-access:business', 'verified', 'checkstatus'])->group(function () {

    Route::get('/profile', [BusinessProfileController::class, 'show'])->name('business.profile');
    Route::put('/business/{user}', [BusinessProfileController::class, 'update'])->name('businessUsers.update');

    Route::put('/business-post/{id}/update', [BusinessProfileController::class, 'updatePost'])->name('businessPost.update');

    Route::get('/business-home', [HomeController::class, 'businessHome'])->name('business.home');
    Route::get('/business/home', [HomeController::class, 'businessPostList'])->name('business.home');

    // Define routes for listing creation
    Route::get('/listings/create/{id}', [ListingController::class, 'create'])->name('listings.create');
    Route::post('/listings', [ListingController::class, 'store'])->name('listings.store');

    Route::get('/listings/latest/update/{id}', [HomeController::class, 'edit'])->name('listings.update');
    Route::put('/listings/latest/update/{id}', [HomeController::class, 'update'])->name('listings.update.put');



    // Route to add a maps
    Route::get('/map', [ListingController::class, 'map'])->name('map');

    // Route to add a maps
    Route::get('/mapAdmin', [ManagePostController::class, 'mapAdmin'])->name('mapAdmin');

    Route::get('/notificationBusiness', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::put('/notifications/markAsRead/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::delete('/notifications/delete/{id}', [NotificationController::class, 'delete'])->name('notifications.delete');
    Route::delete('/notifications/delete-all', [NotificationController::class, 'deleteAll'])->name('notifications.deleteAll');
});




// Normal Users Routes with Email Verification Middleware
Route::middleware(['auth', 'user-access:user', 'verified'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/home', [HomeController::class, 'businessPostListForUser'])->name('home');

    // Route for displaying all business posts
    Route::get('/businessFeatured', [HomeController::class, 'indexFeatured'])->name('businessFeatured.index');

    // Route for displaying a specific business post
    Route::get('/businessFeatured/{id}', [HomeController::class, 'showFeatured'])->name('businessFeatured.show');
});




// Admin Routes
Route::middleware(['auth', 'user-access:admin'])->group(function () {
    Route::get('/admin/dashboard', [HomeController::class, 'adminDashboard'])->name('admin.dashboard');




        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::post('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


        Route::delete('/admin/notifications/delete/{id}', [HomeController::class, 'deleteNotification'])->name('admin.notifications.delete');
        Route::get('/mark-as-read', [HomeController::class, 'markAsRead'])->name('mark-as-read');
        Route::delete('/notifications', [HomeController::class, 'deleteAllNotifications'])->name('admin.notifications.deleteAll');




        Route::get('/main', [App\Http\Controllers\HomeController::class, 'index'])->name('main');
        Route::get('ManagePost', [App\Http\Controllers\ManagePostController::class, 'index'])->name('ManagePost');
        Route::get('ManagePost/sort', [App\Http\Controllers\ManagePostController::class, 'sortTable'])->name('ManagePost.sort');

        Route::get('/ManagePost/create', [ManagePostController::class, 'create'])->name('managepost.create');
        Route::post('/ManagePost/store', [ManagePostController::class, 'store'])->name('managepost.store');




        Route::get('ManagePost/{id}/edit', [ManagePostController::class, 'edit'])->name('ManagePost.edit');
        Route::put('ManagePost/{id}/update', [ManagePostController::class, 'update'])->name('ManagePost.update');
        Route::delete('ManagePost/{id}/delete', [ManagePostController::class, 'destroy'])->name('ManagePost.destroy');
        Route::get('ManagePost/{id}/toggleStatus', [ManagePostController::class, 'toggleStatus'])->name('ManagePost.toggleStatus');

        Route::get('/usersList', [UserController::class, 'index'])->name('users');
        Route::put('/ManagePost/{id}/edit', [UserController::class, 'update'])->name('users.update');
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
        Route::put('/users/{id}/reject', [UserController::class, 'rejectUser'])->name('users.reject');


        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::get('users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('users/store', [UserController::class, 'store'])->name('users.store');
        Route::get('users/{userId}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('users/{userId}/update', [UserController::class, 'update'])->name('users.update');
        Route::delete('users/{userId}/delete', [UserController::class, 'destroy'])->name('users.destroy');
        Route::post('users/{userId}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
        Route::get('users/sort', [UserController::class, 'sortTable'])->name('users.sortTable');



        Route::get('admin/ManageBusiness', [HomeController::class, 'adminManageBusiness'])->name('admin.ManageBusiness');
        Route::get('admin/ManageUser', [HomeController::class, 'adminManageUser'])->name('admin.ManageUser');

        Route::get('/ManageBusiness', [ManageBusinessController::class, 'ManageBusinessForm'])->name('manageBusinessForm');
        Route::post('/ManageBusiness', [ManageBusinessController::class, 'ManageBusiness'])->name('manageBusiness');
});
