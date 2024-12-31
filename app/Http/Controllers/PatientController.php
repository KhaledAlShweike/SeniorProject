<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function addPatient(Request $request)
    {
        // 1. التحقق من صحة البيانات
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'case_number' => 'required|integer|unique:patients,case_number',
            'phone_number' => 'required|string|max:15',
            'password' => 'required|string|min:8',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'required|string',
            'gender' => 'required|in:Male,Female',
            'medical_history' => 'nullable|string',
            'tenant_id' => 'nullable|exists:tenants,id',
        ]);

        // 2. حفظ الصورة إذا وجدت
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('patients', 'public');
        }

        // 3. إضافة المريض إلى قاعدة البيانات
        $patient = Patient::create([
            'name' => $validated['name'],
            'birth_date' => $validated['birth_date'],
            'case_number' => $validated['case_number'],
            'phone_number' => $validated['phone_number'],
            'password' => Hash::make($validated['password']),
            'photo' => $photoPath,
            'address' => $validated['address'],
            'gender' => $validated['gender'],
            'medical_history' => $validated['medical_history'] ?? '',
            'tenant_id' => $validated['tenant_id'] ?? null,
        ]);

        // 4. الاستجابة
        return response()->json([
            'message' => 'Patient added successfully',
            'patient' => $patient,
        ]);
    }
    public function deletePatient($id)
{
    $patient = Patient::find($id);

    if (!$patient) {
        return response()->json([
            'message' => 'Patient not found'
        ], 404);
    }

    // حذف المريض
    $patient->delete();

    return response()->json([
        'message' => 'Patient deleted successfully'
    ]);
}
public function updatePatient(Request $request, $id)
{
    // 1. البحث عن المريض
    $patient = Patient::find($id);
    
    if (!$patient) {
        return response()->json(['message' => 'Patient not found'], 404);
    }

    // 2. التحقق من البيانات (استبعاد كلمة المرور)
    $validated = $request->validate([
        'name' => 'sometimes|string|max:255',
        'birth_date' => 'sometimes|date',
        'case_number' => 'sometimes|integer|unique:patients,case_number,' . $id,
        'phone_number' => 'sometimes|string|max:15',
        'photo' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        'address' => 'sometimes|string',
        'gender' => 'sometimes|in:Male,Female',
        'medical_history' => 'sometimes|string',
        'tenant_id' => 'sometimes|exists:tenants,id',
    ]);

    // 3. تحديث الصورة إذا تم رفع صورة جديدة
    if ($request->hasFile('photo')) {
        $photoPath = $request->file('photo')->store('patients', 'public');
        $validated['photo'] = $photoPath;
    }

    // 4. تحديث البيانات (استبعاد كلمة المرور)
    $patient->update($validated);

    // 5. الاستجابة
    return response()->json([
        'message' => 'Patient updated successfully',
        'patient' => $patient,
    ]);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        //
    }
}
