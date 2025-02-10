<?php

namespace App\Http\Controllers;
use App\Models\user;
use Illuminate\Support\Facades\Hash;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;


class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::all();
        return response()->json($patients, 200);
    }

    public function createPatient(Request $request)
    {
        // التحقق من صحة البيانات المدخلة
        $validator = Validator::make($request->all(), [
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'birthdate'     => 'nullable|date',
            'gender'        => 'nullable|boolean',
            'phone_number'  => 'nullable|string|max:20',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
    
        // إنشاء مريض جديد بدون علاقة بـ User
        $patient = Patient::create([
            'first_name'   => $request->first_name,
            'last_name'    => $request->last_name,
            'birthdate'    => $request->birthdate,
            'gender'       => $request->gender,
            'phone_number' => $request->phone_number,
            'user_id'      => null, // لا يوجد ارتباط بـ User
        ]);
    
        return response()->json([
            'message' => 'تم إضافة المريض بنجاح بدون ارتباط بجدول المستخدم',
            'patient' => $patient,
        ], 201);
    }
    

    public function show($id)
    {
        $patient = Patient::findOrFail($id);
        return response()->json($patient, 200);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'birthdate' => 'sometimes|date',
            'gender' => 'required|in:0,1,2',
            'phone_number' => 'nullable|string|max:20',
        ]);

        $patient = Patient::findOrFail($id);
        $patient->update($data);

        return response()->json(['message' => 'Patient updated successfully', 'patient' => $patient], 200);
    }

    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();

        return response()->json(['message' => 'Patient deleted successfully'], 200);
    }
    public function registerPatient(Request $request)
    {
        // التحقق من صحة البيانات المدخلة كما هي دون إضافات
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);
    
        // إنشاء المستخدم مع فرض role = 2
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 2, // فرض قيمة الدور كمريض
        ]);
    
        // إنشاء سجل للمريض وربطه بالمستخدم
        $user->patient()->create([]);
    
        return response()->json([
            'message' => 'تم تسجيل المريض بنجاح',
            'user' => $user,
        ], 201);
    }
    public function registerPatientt(Request $request)
    {
        // التحقق من صحة البيانات المدخلة
        $validator = Validator::make($request->all(), [
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'user_name'     => 'required|string|max:255|unique:users',
            'email'         => 'required|string|email|max:255|unique:users',
            'password'      => 'required|string|min:6',
            'birthdate'     => 'nullable|date',
            'gender'        => 'nullable|boolean',
            'phone_number'  => 'nullable|string|max:20'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // إنشاء المستخدم في جدول users
        $user = User::create([
            'first_name'   => $request->first_name,
            'last_name'    => $request->last_name,
            'user_name'    => $request->user_name,
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
            'role'         => 2, // 2 تعني أن المستخدم مريض
            'birthdate'    => $request->birthdate,
            'gender'       => $request->gender,
        ]);

        // إنشاء المريض في جدول patients وربطه بالمستخدم
        $patient = Patient::create([
            'first_name'   => $user->first_name,
            'last_name'    => $user->last_name,
            'birthdate'    => $user->birthdate,
            'gender'       => $user->gender,
            'phone_number' => $request->phone_number,
            'user_id'      => $user->id,
        ]);

        return response()->json([
            'message' => 'تم تسجيل المريض بنجاح',
            'user'    => $user,
            'patient' => $patient,
        ], 201);
    }
}
?>
