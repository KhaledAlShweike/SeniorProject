<?php

namespace App\Http\Controllers;

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
            'specialist_id' => 'required|exists:specialists,id', // التحقق من وجود الـ specialist
            'patient_id' => 'required|exists:patients,id',       // التحقق من وجود الـ patient
            'isPrivate' => 'required|in:0,1',                  // استخدام الاسم الصحيح للحقل مع التأكد من أنه قيمة منطقية
            'date' => 'required|date',                          // التحقق من صحة صيغة التاريخ
            'notes' => 'nullable|string',                       // ملاحظات اختيارية
            'treatment_plan' => 'nullable|string',              // خطة العلاج اختيارية
        ]);
    
        // إنشاء سجل جديد في جدول cases
        $case = Cases::create($data);
    
        // إرجاع استجابة ناجحة مع تفاصيل الحالة
        return response()->json([
            'message' => 'Case created successfully',
            'case' => $case,
        ], 201);
    }

    public function show($id)
    {
        $case = Cases::with(['specialist', 'patient', 'diagnoses', 'images', 'visits'])->findOrFail($id);
        return response()->json($case, 200);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'is_private' => 'required|in:0,1',
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
