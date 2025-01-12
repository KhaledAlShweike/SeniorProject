<?php

namespace App\Http\Controllers;

use App\Models\Institution;
use Illuminate\Http\Request;

class InstitutionController
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
    public function show(Institution $institution)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Institution $institution)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Institution $institution)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Institution $institution)
    {
        //
    }
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
