<?php

namespace App\Http\Controllers\Api;

use App\Models\CaseModel;
use App\Models\Cases;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CasesController extends Controller
{
    public function index()
    {
        $cases = Cases::with(['specialist', 'patient', 'diagnoses', 'images', 'visits'])->get();
        return response()->json($cases, 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'specialist_id' => 'required|exists:specialists,id',
            'patient_id' => 'required|exists:patients,id',
            'is_private' => 'boolean',
            'treatment_plan' => 'nullable|string',
        ]);

        $case = Cases::create($data);
        return response()->json(['message' => 'Case created successfully', 'case' => $case], 201);
    }

    public function show($id)
    {
        $case = Cases::with(['specialist', 'patient', 'diagnoses', 'images', 'visits'])->findOrFail($id);
        return response()->json($case, 200);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'is_private' => 'boolean',
            'treatment_plan' => 'nullable|string',
        ]);

        $case = Cases::findOrFail($id);
        $case->update($data);
        return response()->json(['message' => 'Case updated successfully', 'case' => $case], 200);
    }

    public function destroy($id)
    {
        $case = Cases::findOrFail($id);
        $case->delete();
        return response()->json(['message' => 'Case deleted successfully'], 200);
    }
}
