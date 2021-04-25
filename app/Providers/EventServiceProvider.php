<?php

namespace App\Providers;

use App\Models\Application;
use App\Models\Collection;
use App\Observers\ApplicationObserver;
use App\Observers\CollectionObserver;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
        parent::boot();
        // Application::observe(ApplicationObserver::class);
        Collection::observe(CollectionObserver::class);
        
    }
}
