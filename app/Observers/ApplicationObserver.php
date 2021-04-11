<?php

namespace App\Observers;

use App\Models\Application;
use App\Observers\UserObserver;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ApplicationObserver
{
    /**
     * Handle the Application "created" event.
     *
     * @param  \App\Models\Application  $application
     * @return void
     */
    public function created(Application $application)
    {
        //
        // Schema::connection(config('db.connection'))->create($application->slug."_collections", function (Blueprint $table) use ($application){
        //     $table->id();
        //     $table->text('name');
        //     $table->text('label');
        //     $table->longText('fields');
        //     $table->longText('options');
        //     $table->foreignId('application_id')->constrained('applications');
        //     $table->timestamps();
        // });
    }

    /**
     * Handle the Application "updated" event.
     *
     * @param  \App\Models\Application  $application
     * @return void
     */
    public function updated(Application $application)
    {
        //
    }

    /**
     * Handle the Application "deleted" event.
     *
     * @param  \App\Models\Application  $application
     * @return void
     */
    public function deleted(Application $application)
    {
        //
    }

    /**
     * Handle the Application "restored" event.
     *
     * @param  \App\Models\Application  $application
     * @return void
     */
    public function restored(Application $application)
    {
        //
    }

    /**
     * Handle the Application "force deleted" event.
     *
     * @param  \App\Models\Application  $application
     * @return void
     */
    public function forceDeleted(Application $application)
    {
        //
    }
}
