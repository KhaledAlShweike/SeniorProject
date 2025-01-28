<?php

namespace App\Http\Controllers;

use App\Models\Symptom;
use Illuminate\Http\Request;

class SymptomController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
          // التحقق من صحة البيانات الواردة
          $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:symptoms',
            'is_secret' => 'required|boolean',
        ]);

        // إنشاء العرض الجديد
        $symptom = new Symptom();
        $symptom->name = $validatedData['name'];
        $symptom->is_secret = $validatedData['is_secret'];
        $symptom->save();

        // إرجاع استجابة JSON
        return response()->json([
            'message' => 'Symptom registered successfully',
            'symptom' => $symptom,
        ], 201);
    

    }

    /**
     * Display the specified resource.
     */
    public function show(Symptom $symptom)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Symptom $symptom)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $symptom = Symptom::find($id);

        // التحقق مما إذا كان السجل موجودًا
        if (!$symptom) {
            return response()->json(['message' => 'Symptom not found'], 404);
        }

        // التحقق من صحة البيانات المرسلة
        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'is_secret' => 'sometimes|boolean', // يجب أن تكون القيمة منطقية (true أو false)
        ]);

        // تحديث الحقول المرسلة فقط
        foreach ($validatedData as $key => $value) {
            $symptom->$key = $value;
        }

        // حفظ التغييرات
        $symptom->save();

        // الاستجابة
        return response()->json([
            'message' => 'Symptom updated successfully',
            'symptom' => $symptom,
        ], 200);
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $symptom = Symptom::find($id);

        // التحقق مما إذا كان السجل موجودًا
        if (!$symptom) {
            return response()->json(['message' => 'Symptom not found'], 404);
        }

        // حذف السجل
        $symptom->delete();

        // الاستجابة
        return response()->json(['message' => 'Symptom deleted successfully'], 200);
    
    }
}
