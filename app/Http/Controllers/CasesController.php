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
    public function getCaseByPatientId($patient_id, $case_id)
{
    // البحث عن الحالة الطبية الخاصة بالمريض المحدد
    $case = Cases::where('patient_id', $patient_id)
                 ->where('id', $case_id)
                 ->with(['specialist', 'diagnoses', 'images', 'visits'])
                 ->first();

    // التحقق مما إذا كانت الحالة موجودة
    if (!$case) {
        return response()->json(['message' => 'Case not found for this patient'], 404);
    }

    return response()->json($case, 200);
}
public function getCasesByPatientId($patient_id)
{
    // البحث عن جميع الحالات الخاصة بالمريض مع تحميل العلاقات المرتبطة بها
    $cases = Cases::where('patient_id', $patient_id)
                  ->with(['specialist', 'diagnoses', 'images', 'visits'])
                  ->get();

    // التحقق مما إذا كان هناك حالات لهذا المريض
    if ($cases->isEmpty()) {
        return response()->json(['message' => 'No cases found for this patient'], 404);
    }

    return response()->json($cases, 200);
}
public function getPatientsBySpecialistId($specialist_id)
{
    // البحث عن جميع الحالات التي تخص هذا المتخصص
    $cases = Cases::where('specialist_id', $specialist_id)
                  ->with('patient') // تحميل بيانات المريض المرتبط بكل حالة
                  ->get();

    // التحقق مما إذا كان هناك مرضى تابعين لهذا المتخصص
    if ($cases->isEmpty()) {
        return response()->json(['message' => 'No patients found for this specialist'], 404);
    }

    // استخراج قائمة المرضى الفريدة من الحالات
    $patients = $cases->pluck('patient')->unique('id')->values();

    return response()->json($patients, 200);
}
public function getCasesBySpecialistId($specialist_id)
{
    // البحث عن جميع الحالات الخاصة بهذا المتخصص مع تحميل بيانات المريض والتشخيصات والصور والزيارات
    $cases = Cases::where('specialist_id', $specialist_id)
                  ->with(['patient', 'diagnoses', 'images', 'visits'])
                  ->get();

    // التحقق مما إذا كان هناك حالات لهذا المتخصص
    if ($cases->isEmpty()) {
        return response()->json(['message' => 'No cases found for this specialist'], 404);
    }

    return response()->json($cases, 200);
}


}
