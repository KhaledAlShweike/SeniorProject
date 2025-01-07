<?php

namespace App\Http\Controllers;

use App\Models\Specialist;
use Illuminate\Http\Request;

class SpecialistController
{
    /**
     * Display a listing of the resource.
     */
   

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Specialist $specialist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Specialist $specialist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Specialist $specialist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Specialist $specialist)
    {
        //
    }
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'degree' => 'required|integer',
            'specialization' => 'required|integer',
            'certified' => 'required|boolean',
            'institution_id' => 'required|exists:institutions,id',
            'bio' => 'nullable|string',
           
        ]);

        $specialist = new Specialist();
        $specialist->first_name = $validatedData['first_name'];
        $specialist->last_name = $validatedData['last_name'];
        $specialist->degree = $validatedData['degree'];
        $specialist->specialization = $validatedData['specialization'];
        $specialist->certified = $validatedData['certified'];
        $specialist->institution_id = $validatedData['institution_id'];
        $specialist->bio = $validatedData['bio'] ?? null;

        $specialist->save();

        return response()->json([
            'message' => 'Specialist registered successfully',
            'specialist' => $specialist
        ], 201);
    }
    public function index()
{
    $specialists = Specialist::all();
    return response()->json($specialists);
}

}
