<?php

namespace App\Http\Controllers;

use App\Models\Specialist;
use Illuminate\Http\Request;

class SpecialistController
{
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
