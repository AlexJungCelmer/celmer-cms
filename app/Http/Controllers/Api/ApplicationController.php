<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Models\Application;
use \App\Models\Collection;
use Illuminate\Support\Facades\Log;
use App\Modules\RelationModule;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $user = $request->user();
        
        if ($user->tokenCan('*')) {
            return Application::get();
        } else {
            if( $user->tokenCan('application') ){
                return $user->applications()->get();
            }
            // return Application::whereIn('slug', $abilities)->get();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required'],
                'slug' => ['required','unique:applications,slug'],
            ]);
        Log::info("App request valid");
        } catch (\Illuminate\Validation\ValidationException $th) {
            return $th->validator->errors();
        }

        $app = new Application();
        $app->name = $request->name;
        $app->slug = str_slug($request->slug, '-');
        $app->save();
        return $app;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
        
        $user = $request->user();
        if ($user->is_admin) {
            $app = Application::where('slug', $request->slug)->firstOrFail();
            $app['users'] = $app->users()->get();
            return $app;
            
        }
        
        return Application::where('slug', $request->slug)->firstOrFail();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    /**
     * Display all collections from the specified collection
     * 
     * @param Request $slug
     * @return \Illuminate\Http\Response
     */
    public function listCollections(Request $request)
    {
        return Application::where('slug', $request->slug)->firstOrFail()->collections;
    }

}
