<?php

namespace App\Observers;

use App\Models\Collection;
use App\Models\Application;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use App\Modules\RelationModule;

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
         * Need to go to the Observer
         */

        // get the app related to this collection creating
        $app = Application::find($collection->application_id);
        // makes the table name for the collection appended to the app slug
        $table_name = str_replace(' ', '_', $app->slug . '_' . $collection->name);
        /**
         * @todo create a module ModelCreator to control the creating by class methods
         * 
         * Creates the model
         */
        $modelName = str_replace(['-', '_'], ' ', "$app->slug $collection->name");
        $modelName = str_replace(' ', '', lcfirst(ucwords($modelName)));
        Artisan::call("make:model", ['name' => "/ApplicationsModels/$app->slug/$modelName", "--force -n -q"]);

        Schema::connection(config('db.connection'))->create($table_name, function (Blueprint $table) use ($collection, $app, $modelName) {
            $table->id();
            foreach (json_decode($collection->fields) as $field) {
                // create the normal text file input
                if ($field->type == "Text") {
                    try {
                        $table->text($field->name)->nullable(!$field->options->required);
                    } catch (\Throwable $th) {
                        return response(['message' => 'Failed to create text field', 'exception' => $th], 500);
                    }
                } else if (in_array($field->type, ["Select", "Checkbox", "Checkbox", "Radio"])) {
                    // if the field is related to another collection
                    if ($field->options->isRelation == 1) {
                        try {
                            // Get the collection to relate to from the ID, this come from the front-end
                            $collectionToRelate = Collection::find($field->options->isRelatedTo);
                            // get the table to relate to
                            $collectionToRelateTableName = str_replace(' ', '_', $collectionToRelate->application->slug . '_' . $collectionToRelate->name);
                            // Get the collection to relate to from the ID, this come from the front-end
                            $collectionToRelate = Collection::find($field->options->isRelatedTo);
                            // creates the foreign key
                            $table->foreignId("$collectionToRelateTableName" . "_id")->constrained($collectionToRelateTableName);
                        } catch (\Throwable $th) {
                            return response(['message' => 'Failed to create foreignId field', 'exception' => $th], 500);
                        }

                        $relationModule = new RelationModule();
                        try {
                            $relation = $relationModule->createRelation($app->slug, $modelName, $field->name, $collectionToRelateTableName);
                            if ($relation['status'] == 500) {
                                return response(['message' => $relation['message'], 'exception' => ''], $relation['status']);
                            }
                        } catch (\Throwable $th) {
                            return response(['message' => 'Failed to create relation', 'exception' => $th], 500);
                        }
                    } else {
                        /** 
                         * @todo
                         * If is not related to some collection need to have json with value => label to use values preseted 
                         */
                    }
                }
            }
            $table->timestamps();
        });

        /**
         * End observer testing
         */
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
