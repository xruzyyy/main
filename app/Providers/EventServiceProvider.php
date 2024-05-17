<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\ProfileUpdated;
use App\Listeners\UpdateNotificationProfile;
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'App\Events\NewUserRegistered' => [
            'App\Listeners\SendNotificationToAllUsers',
        ],
        'App\Events\BusinessListingAdded' => [
            'App\Listeners\ProcessBusinessListing',
        ],
        'App\Events\MyEvent' => [
            'App\Listeners\MyEventListener',
        ],
        'App\Events\ProfileUpdated' => [
            'App\Listeners\UpdateNotificationProfile',
        ],
        ProfileUpdated::class => [
            UpdateNotificationProfile::class,
        ],
    ];





    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
