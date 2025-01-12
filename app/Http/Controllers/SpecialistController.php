<?php

namespace App\Http\Controllers;

use App\Models\Specialist;
use Illuminate\Http\Request;

class SpecialistController
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'degree' => 'required|integer',
            'specialization' => 'required|integer',
            'certified' => 'required|boolean',
            'institution_id' => 'required|exists:institutions,id',
            'bio' => 'nullable|string',

        ]);

        $specialist = new Specialist();
        $specialist->first_name = $validatedData['first_name'];
        $specialist->last_name = $validatedData['last_name'];
        $specialist->degree = $validatedData['degree'];
        $specialist->specialization = $validatedData['specialization'];
        $specialist->certified = $validatedData['certified'];
        $specialist->institution_id = $validatedData['institution_id'];
        $specialist->bio = $validatedData['bio'] ?? null;

        $specialist->save();

        return response()->json([
            'message' => 'Specialist registered successfully',
            'specialist' => $specialist
        ], 201);
    }
    public function index()
{
    $specialists = Specialist::all();
    return response()->json($specialists);
}
public function deleteSpecialist($id)
{
    // ابحث عن المتخصص بناءً على id
    $specialist = Specialist::find($id);

    // تحقق إذا كان المتخصص موجودًا
    if (!$specialist) {
        return response()->json([
            'message' => 'Specialist not found.'
        ], 404);
    }

    // احذف المتخصص
    $specialist->delete();

    return response()->json([
        'message' => 'Specialist deleted successfully.'
    ], 200);
}
public function updateSpecialist(Request $request, $id)
{
    // ابحث عن المتخصص بناءً على id
    $specialist = Specialist::find($id);

    // تحقق إذا كان المتخصص موجودًا
    if (!$specialist) {
        return response()->json([
            'message' => 'Specialist not found.'
        ], 404);
    }

    // تحديث الحقول إذا تم إرسال قيم جديدة
    $specialist->first_name = $request->input('first_name', $specialist->first_name);
    $specialist->last_name = $request->input('last_name', $specialist->last_name);
    $specialist->degree = $request->input('degree', $specialist->degree);
    $specialist->specialization = $request->input('specialization', $specialist->specialization);
    $specialist->bio = $request->input('bio', $specialist->bio);
    $specialist->certified = $request->input('certified', $specialist->certified);
    $specialist->institution_id = $request->input('institution_id', $specialist->institution_id);

    // حفظ التغييرات في قاعدة البيانات
    $specialist->save();

    return response()->json([
        'message' => 'Specialist updated successfully.',
        'specialist' => $specialist
    ], 200);
}

}
