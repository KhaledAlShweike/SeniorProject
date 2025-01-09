<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MedicalRecordController extends Controller
{
    public function index()
    {
        $medicalRecords = MedicalRecord::with(['patient', 'specialist'])->get();
        return response()->json($medicalRecords, 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'specialist_id' => 'required|exists:specialists,id',
            'diagnosis' => 'required|string',
            'treatment_plan' => 'nullable|string',
            'status' => 'nullable|in:stored,archived',
        ]);

        $medicalRecord = MedicalRecord::create($data);
        return response()->json(['message' => 'Medical record created successfully', 'record' => $medicalRecord], 201);
    }

    public function show($id)
    {
        $medicalRecord = MedicalRecord::with(['patient', 'specialist'])->findOrFail($id);
        return response()->json($medicalRecord, 200);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'diagnosis' => 'nullable|string',
            'treatment_plan' => 'nullable|string',
            'status' => 'nullable|in:stored,archived',
        ]);

        $medicalRecord = MedicalRecord::findOrFail($id);
        $medicalRecord->update($data);
        return response()->json(['message' => 'Medical record updated successfully', 'record' => $medicalRecord], 200);
    }

    public function destroy($id)
    {
        $medicalRecord = MedicalRecord::findOrFail($id);
        $medicalRecord->delete();
        return response()->json(['message' => 'Medical record deleted successfully'], 200);
    }
}
