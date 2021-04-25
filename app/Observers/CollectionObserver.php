<?php

namespace App\Observers;

use App\Models\Collection;
use App\Models\Application;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CollectionObserver
{
    /**
     * Handle the Collection "created" event.
     *
     * @param  \App\Models\Collection  $collection
     * @return void
     */
    public function created(Collection $collection)
    {
        $app = Application::find($collection->application_id);
        $table_name = str_replace(' ', '_', $app->slug . '_' . $collection->name);
        Schema::connection(config('db.connection'))->create($table_name, function (Blueprint $table) use ($collection) {
            $table->id();
            foreach (json_decode($collection->fields) as $field) {
                $table->{$field->type}($field->name);
            }
            $table->timestamps();
        });
    }

    /**
     * Handle the Collection "updated" event.
     *
     * @param  \App\Models\Collection  $collection
     * @return void
     */
    public function updated(Collection $collection)
    {
        //
        // $app = Application::find($collection->application_id);
        // if($collection->isDirty('fields')) {
        //     $oldValueToNewValue = [];
        //     $original = json_decode($collection->getOriginal('fields'));
        //     $new = json_decode($collection->fields); 
        //     foreach($original as $key => $field){
        //         // return $field;
        //         $oldValueToNewValue["$field->name"] = $new[$key]->name;
        //     }
        //     Schema::connection(config('db.connection'))->table($app->slug . '_' . $collection->name, function (Blueprint $table) use ($collection, $oldValueToNewValue) {
        //         foreach ($oldValueToNewValue as $key => $field) {
        //             // dd($key, $field);
        //             $table->renameColumn("$key", "$field");
        //         }
        //     });
        // }
    }

    /**
     * Handle the Collection "deleted" event.
     *
     * @param  \App\Models\Collection  $collection
     * @return void
     */
    public function deleted(Collection $collection)
    {
        //
    }

    /**
     * Handle the Collection "restored" event.
     *
     * @param  \App\Models\Collection  $collection
     * @return void
     */
    public function restored(Collection $collection)
    {
        //
    }

    /**
     * Handle the Collection "force deleted" event.
     *
     * @param  \App\Models\Collection  $collection
     * @return void
     */
    public function forceDeleted(Collection $collection)
    {
        //
    }
}
