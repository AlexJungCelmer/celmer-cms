<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Modules\RelationModule;

/**
 * Will go to the observer
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;



class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //


        $request->name = str_slug($request->name, '_');
        $request->validate([
            'label' => 'required|max:255',
            // 'name' => 'required|unique:collections',
            'fields' => 'required',
        ]);
        $collection = new Collection();
        $collection->label = $request->label;
        $collection->name = $request->name;
        $collection->options = json_encode($request->options);
        $collection->application_id = Application::where('slug', '=', $request->slug)->first()->id;
        $collection->fields = json_encode($request->fields);

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

        return $collection;
        return $collection->save();
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
        return Collection::where('name', $request->collection)->firstOrFail();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $request->validate([
            'id' => 'required',
            'label' => 'required|max:255',
            'fields' => 'required',
        ]);
        $collection = Collection::find($request->id);
        $collection->label = $request->label;
        $collection->options = $request->options;
        $collection->fields = json_encode($request->fields);

        /**
         * will go to the observer.
         */
        $oldValueToNewValue = [];
        $app = Application::find($collection->application_id);
        if ($collection->isDirty('fields')) {
            $oldValueToNewValue = [];
            $original = json_decode($collection->getOriginal('fields'));
            $new = json_decode($collection->fields);
            /**
             * Makes a key value pair to from Old field name to new field name to change rename it
             * if none has changes no problem, will keep the same.
             */
            $i = 0;
            foreach ($original as $key => $field) {
                // return $field;
                $oldValueToNewValue[$i]["$field->name"] = $new[$key]->name;
                $oldValueToNewValue[$i]["$field->type"] = $new[$key]->type;
                $i++;
            }
            // dd($oldValueToNewValue);
            // Schema::connection(config('db.connection'))->table($app->slug . '_' . $collection->name, function (Blueprint $table) use ($collection, $oldValueToNewValue) {
            //     foreach ($oldValueToNewValue as $key => $field) {
            //         $table->renameColumn("$key", $field['name']);
            //     }
            // });
        }

        return $oldValueToNewValue;
        return $collection->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function destroy(Collection $collection)
    {
        //
    }
}
