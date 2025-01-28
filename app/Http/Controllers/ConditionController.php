<?php

namespace App\Http\Controllers;

use App\Models\Condition;
use Illuminate\Http\Request;

class ConditionController
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
         // تحقق من صحة البيانات المدخلة
         $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'probability' => 'required|numeric|min:0|max:1', // احتمال يجب أن يكون بين 0 و 1
        ]);

        // إنشاء وحفظ الحالة
        $condition = new Condition();
        $condition->name = $validatedData['name'];
        $condition->probability = $validatedData['probability'];
        $condition->save();

        // استجابة JSON عند نجاح العملية
        return response()->json([
            'message' => 'Condition registered successfully',
            'condition' => $condition,
        ], 201);
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Condition $condition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Condition $condition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $condition = Condition::find($id);

        // التحقق مما إذا كان السجل موجودًا
        if (!$condition) {
            return response()->json(['message' => 'Condition not found'], 404);
        }

        // التحقق من صحة البيانات المرسلة
        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'probability' => 'sometimes|numeric|min:0|max:1', // قيمة احتمالية بين 0 و 1
        ]);

        // تحديث الحقول المرسلة فقط
        foreach ($validatedData as $key => $value) {
            $condition->$key = $value;
        }

        // حفظ التغييرات
        $condition->save();

        // الاستجابة
        return response()->json([
            'message' => 'Condition updated successfully',
            'condition' => $condition,
        ], 200);
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $condition = Condition::find($id);

        // التحقق مما إذا كان السجل موجودًا
        if (!$condition) {
            return response()->json(['message' => 'Condition not found'], 404);
        }

        // حذف السجل
        $condition->delete();

        // الاستجابة
        return response()->json(['message' => 'Condition deleted successfully'], 200);
    
    }
}
