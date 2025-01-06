<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class DoctorController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $doctor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Doctor $doctor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        //
    }

    public function addDoctor(Request $request)
    {
        // 1. التحقق من صحة البيانات
        $validated = $request->validate([
            'DoctorName' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:doctors,email',
            'password' => 'required|string|min:8',
            'phone_number' => 'required|string|max:15',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'role' => 'required|string|max:50',
            'specialization' => 'required|string|max:100',
            'clinic_address' => 'required|string|max:255',
        ]);

        // 2. حفظ الصورة إذا وجدت
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('doctors', 'public');
        }

        // 3. إضافة الطبيب إلى قاعدة البيانات
        $doctor = Doctor::create([
            'DoctorName' => $validated['DoctorName'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone_number' => $validated['phone_number'],
            'photo' => $photoPath,
            'role' => $validated['role'],
            'specialization' => $validated['specialization'],
            'clinic_address' => $validated['clinic_address'],
        ]);

        // 4. الاستجابة
        return response()->json([
            'message' => 'Doctor added successfully',
            'doctor' => $doctor,
        ]);
    }


    public function deleteDoctor($id)
{
    // العثور على الطبيب حسب ال ID
    $doctor = Doctor::find($id);

    // التحقق إذا كان الطبيب موجود
    if (!$doctor) {
        return response()->json([
            'message' => 'Doctor not found'
        ], 404);
    }

    // حذف صورة الطبيب إذا وجدت
    if ($doctor->photo) {
        Storage::disk('public')->delete($doctor->photo);
    }

    // حذف الطبيب من قاعدة البيانات
    $doctor->delete();

    // استجابة بعد الحذف
    return response()->json([
        'message' => 'Doctor deleted successfully'
    ]);
}
public function updateDoctor(Request $request, $id)
{
    // البحث عن الطبيب
    $doctor = Doctor::find($id);

    if (!$doctor) {
        return response()->json([
            'message' => 'Doctor not found'
        ], 404);
    }

    // التحقق من صحة البيانات
    $validated = $request->validate([
        'DoctorName' => 'nullable|string|max:255',
        'email' => 'nullable|email|unique:doctors,email,' . $id . ',DoctorID',
        'phone_number' => 'nullable|string|max:15',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'role' => 'nullable|string',
        'specialization' => 'nullable|string|max:255',
        'clinic_address' => 'nullable|string|max:255',
    ]);

    // تحديث الصورة إذا وُجدت
    if ($request->hasFile('photo')) {
        // حذف الصورة القديمة
        if ($doctor->photo) {
            Storage::disk('public')->delete($doctor->photo);
        }
        // حفظ الصورة الجديدة
        $photoPath = $request->file('photo')->store('doctors', 'public');
        $doctor->photo = $photoPath;
    }

    // تحديث البيانات الأخرى باستثناء كلمة المرور
    $doctor->fill($validated);
    $doctor->save();

    return response()->json([
        'message' => 'Doctor updated successfully',
        'doctor' => $doctor,
    ]);
}






}
