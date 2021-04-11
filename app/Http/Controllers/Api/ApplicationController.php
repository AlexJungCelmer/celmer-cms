<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Models\Application;
use \App\Models\Collection;

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
        $app = new Application();
        $app->name = $request->name;
        $app->slug = str_slug($request->name, '-');
        $app->save();
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
        if ($user->tokenCan('*') && $user->is_admin) {
            return Application::where('slug', $request->slug)->firstOrFail()->with('users')->firstOrFail();
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
