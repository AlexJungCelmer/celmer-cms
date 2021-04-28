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
        /**
         * Find the app related to the collection.
         */
        $app = Application::find($collection->application_id);
        /**
         * Replace any space  to _ to prevent problems with table name.
         * @todo make a function to make a proper replace.
         */
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
     * !IMPORTANT this will only trigger when the collection is dirty.
     * @param  \App\Models\Collection  $collection
     * @return void
     */
    public function updated(Collection $collection)
    {
        //
        /**
         * Find the app related to the collection
         */
        $app = Application::find($collection->application_id);

        /**
         * Checks if the collection fields has bem changed.
         */
        if($collection->isDirty('fields')) {
            $oldValueToNewValue = [];
            $original = json_decode($collection->getOriginal('fields'));
            $new = json_decode($collection->fields);
            /**
             * Makes a key value pair to from Old field name to new field name to change rename it
             * if none has changes no problem, will keep the same.
             */
            foreach($original as $key => $field){
                // return $field;
                $oldValueToNewValue["$field->name"]['name'] = $new[$key]->name;
                $oldValueToNewValue["$field->name"]['type'] = $new[$key]->type;
            }
            // dd($oldValueToNewValue);
            Schema::connection(config('db.connection'))->table($app->slug . '_' . $collection->name, function (Blueprint $table) use ($collection, $oldValueToNewValue) {
                foreach ($oldValueToNewValue as $key => $field) {
                    $table->renameColumn("$key", $field['name']);
                }
            });
        }
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
