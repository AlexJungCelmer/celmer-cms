<?php

namespace App\Observers;

use App\Models\Application;
use App\Observers\UserObserver;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

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
        Log::info("Application created $application->name ... $application->slug");
        // Dont thing i will need this anymore, here just in case.
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
        Log::info("Application updated $application->name ... $application->slug");
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
        Log::info("Application deleted $application->name ... $application->slug");
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
        Log::info("Application restored $application->name ... $application->slug");
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
        Log::info("Application forcedDeleted $application->name ... $application->slug");
        //
    }
}
