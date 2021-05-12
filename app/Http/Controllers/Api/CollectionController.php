<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Application;
use Illuminate\Http\Request;
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
            'name' => 'required|unique:collections',
            'fields' => 'required',
        ]);
        $collection = new Collection();
        $collection->label = $request->label;
        $collection->name = $request->name;
        $collection->options = json_encode($request->options);
        $collection->application_id = Application::where('slug', '=', $request->slug)->first()->id;
        $collection->fields = json_encode($request->fields);

        $app = Application::find($collection->application_id);
        $modelName = str_replace('-', ' ', "$app->slug $collection->name");
        $modelName = str_replace(' ', '', ucwords($modelName));

        Artisan::call("make:model", ["name" => $modelName , "--force -n -q"]);

        // return $collection;
        // return $collection->save();
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
