<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Application;
use Illuminate\Http\Request;

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
        $collection->name = str_slug($request->name, '_');
        $collection->options = $request->options;
        $collection->application_id = Application::where('slug', '=', $request->slug)->first()->id;
        $collection->fields = json_encode($request->fields);
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
        
        // return 'a';
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
