<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Application;
use Illuminate\Http\Request;


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


        // return $collection;
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
        // return [
        //     json_decode($collection->fields),
        //     $request->fields
        // ];
        $collection->label = $request->label;
        $collection->options = $request->options;
        $collection->fields = json_encode($request->fields);

        $newCollumnsName = [];

        foreach ($request->fields as $newField) {
            $contains = false;
            foreach (json_decode($collection->fields) as $oldField) {
                if($newField['name'] == $oldField->name){
                    $contains = true;
                }
            }

            if(!$contains){
                $newCollumnsName[] = $newField;
            }
            $contains = false;
        }
        return $newCollumnsName;

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
             * Makes a key value pair to from Old field name to new field 
             * name to change rename it if none has changes no problem, 
             * will keep the same.
             */
            $i = 0;
            foreach (json_decode($request->fields) as $key => $field) {
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

    // @TODO: the entries function will go to another controller !important
    public function entries(Request $request)
    {
        //make the name to find the specified model inside the application models folder
        $app_collections = Application::where('slug', $request->slug)->firstOrFail()->collections->toArray();
        $collection = '';
        foreach ($app_collections as $value){
            if($value['name'] == $request->collection){
                $collection = $value;
                break;
            }
        }
        $relationsId = [];
        $fields = json_decode($collection['fields']);
        // return $fields[0]->name == 'new';
        foreach ($fields as $field){
            $field_options = json_decode(json_encode($field->options), true);
            if($field_options['isRelation']){
                $relationsId[] = $field_options['isRelatedTo'];
            }
        }

        $relatedCollections = Collection::select('name')->whereIn('id', $relationsId)->get();
        $relatedCollectionsName = [];
        foreach ($relatedCollections as $relatedCollection){
            $relatedCollectionsName[] = $relatedCollection->name;
        }

        // return $relatedCollectionsName;
        

        $modelName = str_replace(['-', '_'], ' ', "$request->slug" . "$request->collection");
        $modelName = str_replace(' ', '', lcfirst(ucwords($modelName)));
        // return $request->collection;
        $class = '\\App\\Models\\ApplicationsModels\\' . $request->slug . '\\' . $modelName;
        if (class_exists($class)) {
            return $class::with($relatedCollectionsName)->get();
        } else {
            return response(json_encode(['message' => 'Model não encontrada.']), 404);
        }
    }

    public function getEntrie(Request $request)
    {
        //make the name to find the specified model inside the application models folder
        $modelName = str_replace(['-', '_'], ' ', "$request->slug" . "$request->collection");
        $modelName = str_replace(' ', '', lcfirst(ucwords($modelName)));

        $class = '\\App\\Models\\ApplicationsModels\\' . $request->slug . '\\' . $modelName;
        if (class_exists($class)) {
            return $class::find($request->id);
        } else {
            return response(json_encode(['message' => 'Entrada não encontrada.']), 404);
        }
    }
}
