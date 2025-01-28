<?php

namespace App\Http\Controllers;

use App\Models\Diagnosis;
use Illuminate\Http\Request;

class DiagnosisController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Diagnosis = Diagnosis::with(['Symptom','Condition'])->get();
        return response()->json($Diagnosis, 200);
    }

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
              // التحقق من البيانات
              $validatedData = $request->validate([
                'condition_id' => 'required|exists:conditions,id',
                'symptom_id' => 'required|exists:symptoms,id',
                'case_id' => 'required|exists:cases,id',
                'probability' => 'required|boolean',
                'last_updated' => 'required|date',
            ]);
    
            // إنشاء تشخيص جديد
            $diagnosis = new Diagnosis();
            $diagnosis->condition_id = $validatedData['condition_id'];
            $diagnosis->symptom_id = $validatedData['symptom_id'];
            $diagnosis->case_id = $validatedData['case_id'];
            $diagnosis->probability = $validatedData['probability'];
            $diagnosis->last_updated = $validatedData['last_updated'];
    
            $diagnosis->save(); // حفظ التشخيص في قاعدة البيانات
    
            return response()->json([
                'message' => 'Diagnosis registered successfully',
                'diagnosis' => $diagnosis
            ], 201);
        
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $Diagnosis = Diagnosis::with(['Symptom','Condition'])->findOrFail($id);
        return response()->json($Diagnosis, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Diagnosis $diagnosis)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $diagnose = Diagnosis::find($id);

        // التحقق مما إذا كان التشخيص موجودًا
        if (!$diagnose) {
            return response()->json(['message' => 'Diagnose not found'], 404);
        }

        // التحقق من صحة البيانات الواردة
        $validatedData = $request->validate([
            'condition_id' => 'sometimes|exists:conditions,id',
            'symptom_id' => 'sometimes|exists:symptoms,id',
            'case_id' => 'sometimes|exists:cases,id',
            'probability' => 'sometimes|boolean',
            'last_updated' => 'sometimes|date',
        ]);

        // تحديث الحقول المرسلة فقط
        foreach ($validatedData as $key => $value) {
            $diagnose->$key = $value;
        }

        // حفظ البيانات بعد التعديل
        $diagnose->save();

        // الاستجابة
        return response()->json([
            'message' => 'Diagnose updated successfully',
            'diagnose' => $diagnose,
        ], 200);
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $Diagnosis = Diagnosis::findOrFail($id);
        $Diagnosis->delete();
        return response()->json(['message' => 'Diagnosis deleted successfully'], 200);
    }
}
