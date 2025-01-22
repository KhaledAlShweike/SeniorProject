<?php

namespace App\Http\Controllers;

use App\Models\Institution;
use Illuminate\Http\Request;

class InstitutionController
{
    public function addInstitution(Request $request)
    {
        // التحقق من صحة البيانات
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
        ]);

        // إضافة المؤسسة إلى قاعدة البيانات
        $institution = Institution::create([
            'name' => $validatedData['name'],
            'address' => $validatedData['address'] ?? null,
        ]);

        // الاستجابة
        return response()->json([
            'message' => 'Institution added successfully',
            'institution' => $institution,
        ], 201);
    }
    public function deleteInstitution($id)
{
    // ابحث عن السجل بناءً على id
    $institution = Institution::find($id);

    // تحقق إذا كان السجل موجودًا
    if (!$institution) {
        return response()->json([
            'message' => 'Institution not found.'
        ], 404);
    }

    // احذف السجل
    $institution->delete();

    return response()->json([
        'message' => 'Institution deleted successfully.'
    ], 200);
}
public function updateInstitution(Request $request, $id)
{
    // ابحث عن السجل بناءً على id
    $institution = Institution::find($id);

    // تحقق إذا كان السجل موجودًا
    if (!$institution) {
        return response()->json([
            'message' => 'Institution not found.'
        ], 404);
    }

    // قم بتحديث البيانات
    $institution->name = $request->input('name', $institution->name); // تحديث الاسم إذا أُرسل
    $institution->address = $request->input('address', $institution->address); // تحديث العنوان إذا أُرسل
    $institution->save(); // حفظ التحديثات في قاعدة البيانات

    return response()->json([
        'message' => 'Institution updated successfully.',
        'institution' => $institution
    ], 200);
}
}
