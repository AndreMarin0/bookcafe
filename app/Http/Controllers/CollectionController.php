<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Author;
use App\Models\Genre;
use App\Models\Publisher;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCollectionRequest;
use App\Http\Requests\UpdateCollectionRequest;
use Illuminate\Support\Facades\DB;


class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $collections = Collection::all();
        return view('BookCafe_Sys.bc_collection', compact('collections'));
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $authors= Author::all();
        $genres= Genre::all();
        $publishers= Publisher::all();
        $collections = Collection::all();
        return view('BookCafe_Sys.book_create',compact('collections','authors','genres','publishers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCollectionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCollectionRequest $request)
    {
        Collection::create($request->all());
        // Author::create($request->all());
        // Genre::create($request->all());
        // Publisher::create($request->all());
        return redirect('/collections')->with('success', 'Form submitted successfully!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function show(Collection $collection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function edit(Collection $collection)
    {
        $authors= Author::all();
        $genres= Genre::all();
        $publishers= Publisher::all();
        return view('BookCafe_Sys.book_edit',compact('collection','authors','genres','publishers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCollectionRequest  $request
     * @param  \App\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCollectionRequest $request, Collection $collection)
    {   
       
        $collection->update($request->all());
        return redirect('/collections')->with('success2', 'Form updated successfully!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function destroy(Collection $collection)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('collections.index')->with('error', 'Access denied: Only admin can delete books');
        }
        $collection->delete();
        return redirect('/collections')->with('success3', 'Deleted successfully!');
    }
}
