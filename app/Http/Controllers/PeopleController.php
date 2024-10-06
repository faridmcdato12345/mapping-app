<?php

namespace App\Http\Controllers;

use App\Models\People;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PeopleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('people');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    public function api(){
        $people = People::all();
        foreach($people as $p){
            $p['color_marker'] = $p->marker_color;
            $p['expiration_date'] = $p->expiration_date ? Carbon::parse($p->expiration_date)->format('F j, Y') : 'Undefined';
        }
        return response()->json($people);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'photo_path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Store the photo in the 'public' disk
        $path = $request->file('photo_path')->store('photos', 'public');
        $data = $request->all();
        $data['photo_path'] = $path;
        People::create($data);
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(People $people)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(People $people)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, People $people)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(People $people)
    {
        //
    }
}
