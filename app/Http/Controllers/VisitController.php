<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use Illuminate\Http\Request;

class VisitController
{

    public function index()
    {
        $visits = Visit::with('case')->get(); // تضمين بيانات الحالة المرتبطة
        return response()->json($visits, 200);
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'case_id' => 'required|exists:cases,id',
            'date' => 'required|date',
            'note' => 'nullable|string',
        ]);

        $visit = Visit::create($data);

        return response()->json(['message' => 'Visit created successfully', 'visit' => $visit], 201);
    }


    public function show($id)
    {
        $visit = Visit::with('case')->findOrFail($id);
        return response()->json($visit, 200);
    }


    public function update(Request $request,$id )
    {
        $data = $request->validate([
            'date' => 'required|date',
            'note' => 'nullable|string',
        ]);

        $visit = Visit::findOrFail($id);
        $visit->update($data);

        return response()->json(['message' => 'Visit updated successfully', 'visit' => $visit], 200);
    }

   
    public function destroy($id)
    {
        $visit = Visit::findOrFail($id);
        $visit->delete();

        return response()->json(['message' => 'Visit deleted successfully'], 200);
    }
}
