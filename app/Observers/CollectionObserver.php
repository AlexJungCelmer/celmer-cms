<?php

namespace App\Observers;

use App\Models\Collection;
use App\Models\Application;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use App\Modules\RelationModule;
use Str;
use Exception;
use Illuminate\Support\Facades\Log;

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

        // get the app related to this collection creating
        $app = Application::find($collection->application_id);

        // makes the table name for the collection appended to the app slug
        $table_name = $table_name = str_replace(' ', '_', $app->slug . '_').Str::snake(Str::plural(class_basename($collection->name)));

        //creates the model
        Log::debug("creating the model");
        $modelName = $this->createModel($app->slug, $collection->name);
        Log::debug("modelName $modelName");
        
        if(!$modelName) {
            $collection->forceDelete();
            throw new Exception("Something whent wrong at model creation", 2001);
        }
            
        $fields = [];
        // need to fix this shit, double decode
        $collection->fields = json_decode($collection->fields);

        foreach (json_decode($collection->fields) as $field) {            
            if (in_array($field->type, ["select", "checkbox", "radio"])) {
                // if the field is related to another collection
                if ($field->isRelation == 1) {
                    try {
                        // Get the collection to relate to from the ID, this come from the front-end
                        $collectionToRelate = Collection::find($field->isRelatedTo);
                        // get the table to relate to
                        $collectionToRelateTableName = str_replace(' ', '_', $collectionToRelate->application->slug . '_' . $collectionToRelate->name);
                        // creates the foreign key type field 
                        $fields[$collectionToRelateTableName+'_id'] = [
                            'type' => 'foreignId',
                            'nullable' => true,
                            'references' => $collectionToRelateTableName,
                            'onDelete' => 'cascade',
                        ];
                    } catch (\Throwable $th) {
                        return response(['message' => 'Failed to create foreignId field', 'exception' => $th], 500);
                    }

                    $relationModule = new RelationModule();
                    try {
                        $relation = $relationModule->createRelation($app->slug, $modelName, $field->name, $collectionToRelateTableName);
                    } catch (\Throwable $th) {
                        throw new Exception("Error Processing Request", 2002);
                        
                    }
                } else {
                    /** 
                     * @todo
                     * If is not related to some collection need to have json with value => label to use values preseted 
                     */
                }
            } else {
                // if is a field without relations just make it.
                $fields[] = [
                    'name' => $field->name,
                    'options' => $field->options, 
                ];
            }
        }
        Log::debug(json_encode($fields));
        Log::debug("Fields created, starting the table");

        Schema::connection(config('db.connection'))->create($table_name, function (Blueprint $table) use ($collection, $app, $modelName, $fields) {
            $table->id();
            foreach ($fields as $field) {
                // Get the field type
                $fieldType = $field['options']->type;
                
                //type is not supported on Migrations
                unset($field['options']->type);

                if ($fieldType === 'foreignId') {
                    // Cria uma coluna de chave estrangeira
                    $table->foreignId($fieldName)
                          ->nullable($field["options"]->nullable)
                          ->onDelete($field['onDelete']);
                } else {
                    // Cria uma coluna regular
                    Log::debug(json_encode($field['options']));
                    $table->$fieldType($field["name"])->nullable($field["options"]->nullable);
                }
            }
            $table->timestamps();
        });
        Log::debug("Table Created");

        /**
         * End observer testing
         */
    }

    /**
     * Handle the creation of model file.
     * 
     * @param String appSlug 
     * @param String collectionName
     * 
     * @return String
     */
    private function createModel($appSlug, $collectionName){
        try {
            $modelName = str_replace(['-', '_'], ' ', "$appSlug $collectionName");
            $modelName = str_replace(' ', '', lcfirst(ucwords($modelName)));
            Artisan::call("make:model", ['name' => "/ApplicationsModels/$appSlug/$modelName", "--force -n -q"]);
            return $modelName;
        } catch (\Throwable $th) {
            // throw new Exception("Error make:model on createModel", 2000);
        }
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
