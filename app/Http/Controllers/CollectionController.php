<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Author;
use App\Models\Genre;
use App\Models\Publisher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCollectionRequest;
use App\Http\Requests\UpdateCollectionRequest;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Support\Facades\DB;



class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Collection::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('BookID', 'like', "%{$search}%")
                ->orWhere('Description', 'like', "%{$search}%")
                ->orWhereHas('author', function($query) use ($search) {
                        $query->where('AuthorName', 'like', "%{$search}%");
                })
                ->orWhereHas('publisher', function($query) use ($search) {
                        $query->where('PublisherName', 'like', "%{$search}%");
                })
                ->orWhereHas('genre', function($query) use ($search) {
                        $query->where('Genre', 'like', "%{$search}%");
                });
            });

            session(['search' => $search]); // save the search keyword in session
        } else {
            session()->forget('search'); // remove the search keyword from session if not set
        }

        if ($request->filled('filter')) {
            $filter = $request->input('filter');
            $query->whereHas('genre', function($query) use ($filter) {
                $query->where('Genre', $filter);
            })->orWhereHas('author', function($query) use ($filter) {
                $query->where('AuthorName', $filter);
            })->orWhereHas('publisher', function($query) use ($filter) {
                $query->where('PublisherName', $filter);
            });

            session(['filter' => $filter]); // save the filter keyword in session
        } else {
            session()->forget('filter'); // remove the filter keyword from session if not set
        }

        $perPage = 5;
        $collections = $query->paginate($perPage);
        $collections->appends($request->query());

        $count = $collections->total();
        $message = ($count === 1) ? '1 result found' : "$count results found";

        return view('BookCafe_Sys.bc_collection', compact('collections', 'message'));
    }




    public function generatePDF(Request $request)
    {
        $search = session('search');
        $filter = session('filter');
    
        $query = Collection::query();
    
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('BookID', 'like', "%{$search}%")
                  ->orWhere('Description', 'like', "%{$search}%")
                  ->orWhereHas('author', function ($query) use ($search) {
                        $query->where('AuthorName', 'like', "%{$search}%");
                  })
                  ->orWhereHas('publisher', function ($query) use ($search) {
                        $query->where('PublisherName', 'like', "%{$search}%");
                  })
                  ->orWhereHas('genre', function ($query) use ($search) {
                        $query->where('Genre', 'like', "%{$search}%");
                  });
            });
        }
    
        if ($filter) {
            $query->where(function ($q) use ($filter) {
                $q->where('BookID', $filter)
                ->orWhereHas('genre', function ($query) use ($filter) {
                    $query->where('Genre', $filter);
              })
                  ->orWhereHas('author', function ($query) use ($filter) {
                        $query->where('AuthorName', $filter);
                  })
                  ->orWhereHas('publisher', function ($query) use ($filter) {
                    $query->where('PublisherName', $filter);
                });
            });

            session(['filter' => $filter]); // save the filter keyword in session
        } else {
            session()->forget('filter'); // remove the filter keyword from session if not set
        }

        

        $collections = $query->get();

        $pdf = PDF::loadView('book-pdf', compact('collections'));
        return $pdf->download('book-collections.pdf');
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
        // Collection::create($request->all());
        $this->validate($request, [
            'Description' => 'required',           
        ]);
    
        $collection = new Collection();
        $collection->Description = $request->input('Description');
        $collection->AuthorID = $request->AuthorID; // Add this line to set the AuthorID
        $collection->PubID = $request->PubID;
        $collection->GenID = $request->GenID;
        $collection->save();
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
