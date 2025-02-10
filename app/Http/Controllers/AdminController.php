<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\models\patient;
use App\Models\Specialist;
use App\Models\Institution;

class AdminController extends Controller
{
    /**
     * Admin Login with Sanctum Token
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $admin = User::where('email', $request->email)->whereHas('role', function ($query) {
            $query->where('title', 'admin');
        })->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $admin->createToken('admin-token')->plainTextToken;

        return response()->json(['token' => $token]);
    }

    /**
     * Get Pending Specialists for Approval
     */
    public function getPendingSpecialists()
    {
        $specialists = Specialist::whereNull('certified')->get();
        return response()->json($specialists);
    }

    /**
     * Approve or Reject a Specialist
     */
    public function updateSpecialistStatus(Request $request, $id)
    {
        $request->validate([
            'certified' => 'required|boolean'
        ]);

        $specialist = Specialist::findOrFail($id);
        $specialist->certified = $request->certified;
        $specialist->save();

        return response()->json(['message' => "Specialist has been " . ($request->certified ? "approved" : "rejected")]);
    }

    /**
     * Get All Specialists
     */
    public function getSpecialists()
    {
        $Specialists = Specialist::all();
        return response()->json($Specialists);
    }

    /**
     * Add a New Specialist
     */
    public function addSpecialist(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'specialization' => 'required',
            'institution_id' => 'required|exists:institutions,id'
        ]);

        $Specialist = Specialist::create([
            'name' => $request->name,
            'email' => $request->email,
            'specialization' => $request->specialization,
            'institution_id' => $request->institution_id
        ]);

        return response()->json(['message' => 'Specialist added successfully', 'Specialist' => $Specialist]);
    }

    /**
     * Update Specialist Information
     */
    public function updateSpecialist(Request $request, $id)
    {
        $Specialist = Specialist::findOrFail($id);
        $Specialist->update($request->only(['name', 'specialization']));

        return response()->json(['message' => 'Specialist information updated']);
    }

    /**
     * Remove a Specialist
     */
    public function deleteSpecialist($id)
    {
        Specialist::findOrFail($id)->delete();
        return response()->json(['message' => 'Specialist removed successfully']);
    }

    /**
     * Get All Institutions
     */
    public function getInstitutions()
    {
        $institutions = Institution::all();
        return response()->json($institutions);
    }

    /**
     * Add a New Institution
     */
    public function addInstitution(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required|integer',
            'address' => 'required'
        ]);

        $institution = Institution::create($request->all());

        return response()->json(['message' => 'Institution added successfully', 'institution' => $institution]);
    }

    /**
     * Update Institution Information
     */
    public function updateInstitution(Request $request, $id)
    {
        $institution = Institution::findOrFail($id);
        $institution->update($request->only(['name', 'type', 'address']));

        return response()->json(['message' => 'Institution details updated']);
    }

    /**
     * Remove an Institution
     */
    public function deleteInstitution($id)
    {
        Institution::findOrFail($id)->delete();
        return response()->json(['message' => 'Institution removed successfully']);
    }
    public function getUserById($id)
{
    try {
        // البحث عن المستخدم
        $user = User::findOrFail($id);

        // إذا كان المستخدم مختصًا (role = 1)، اجلب بياناته من جدول المختصين
        if ($user->role == 1) {
            $specialist = Specialist::where('user_id', $user->id)->first();

            if ($specialist) {
                return response()->json([
                    'user' => $user,
                    'specialist' => $specialist
                ], 200);
            }
        }

        // إذا لم يكن مختصًا، إرجاع بيانات المستخدم فقط
        return response()->json([
            'user' => $user
        ], 200);
        
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'فشل العثور على المستخدم.',
            'details' => $e->getMessage()
        ], 404);
    }
}
public function getpatientById($id)
{
    // البحث عن المستخدم حسب الـ ID
    $user = User::find($id);

    if (!$user) {
        return response()->json(['error' => 'المستخدم غير موجود'], 404);
    }

    // إذا كان دور المستخدم (role) = 2، فاجلب بياناته من جدول المرضى أيضًا
    if ($user->role == 2) {
        $patient = Patient::where('user_id', $user->id)->first();

        if (!$patient) {
            return response()->json(['error' => 'لم يتم العثور على معلومات المريض لهذا المستخدم'], 404);
        }

        // دمج بيانات المستخدم مع بيانات المريض
        $userData = [
            'id'           => $user->id,
            'first_name'   => $user->first_name,
            'last_name'    => $user->last_name,
            'user_name'    => $user->user_name,
            'email'        => $user->email,
            'role'         => $user->role,
            'birthdate'    => $user->birthdate,
            'gender'       => $user->gender,
            'status'       => $user->status,
            'profile_pic_url' => $user->profile_pic_url,
            'created_at'   => $user->created_at,
            'updated_at'   => $user->updated_at,
            'patient_info' => [
                'patient_id'   => $patient->id,
                'phone_number' => $patient->phone_number,
                'created_at'   => $patient->created_at,
                'updated_at'   => $patient->updated_at,
            ],
        ];

        return response()->json($userData, 200);
    }

    // إذا لم يكن المستخدم مريضًا، أعد بياناته فقط
    return response()->json($user, 200);
}

public function getPatientsWithoutUser()
{
    // جلب جميع المرضى الذين ليس لديهم user_id مرتبط بجدول users (أي أن user_id = null)
    $patients = Patient::whereNull('user_id')->get();

    if ($patients->isEmpty()) {
        return response()->json(['message' => 'لا يوجد مرضى غير مرتبطين بمستخدم'], 200);
    }

    return response()->json($patients, 200);
}

}
