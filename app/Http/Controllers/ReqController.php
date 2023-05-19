<?php

namespace App\Http\Controllers;

use App\Models\Req;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReqRequest;
use App\Http\Requests\UpdateReqRequest;
use Illuminate\Http\Request;


class ReqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requests = Req::all();
        return view('BookCafe_Sys.book_request', compact('requests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreReqRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReqRequest $request)
    {
        $validatedData = $request->validate([
            'requests' => 'required',
            'message' => 'required',
        ]);
    
        $req = new Req();
        $req->Requests = $validatedData['requests'];
        $req->Message = $validatedData['message'];
        $req->save();
    
        return redirect()->back()->with('success', 'Request sent successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Req  $req
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $request->validate([
            'requests' => 'required',
            'message' => 'required',
        ]);
    
        $req = new Req();
        $req->Requests = $request->input('requests');
        $req->Message = $request->input('message');
        $req->save();
    
        return redirect()->back()->with('success', 'Request sent successfully!');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Req  $req
     * @return \Illuminate\Http\Response
     */
    public function edit(Req $req)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateReqRequest  $request
     * @param  \App\Models\Req  $req
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReqRequest $request, Req $req)
    {
        //
    }

    public function updateStatus(UpdateReqRequest $request, Req $req)
    {
        $req->update([
            'Stat' => $request->input('Stat', $req->Stat),
        ]);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Req  $req
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Req $req)
    {     
        $req->delete();
        return redirect()->back();    
    }

}
