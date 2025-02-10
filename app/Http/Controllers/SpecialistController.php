<?php

namespace App\Http\Controllers;
use App\Models\user;
use Illuminate\Support\Facades\Hash;
use App\Models\Specialist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
//public function deleteSpecialist($id)
//{
    // ابحث عن المتخصص بناءً على id
  //  $specialist = Specialist::find($id);

    // تحقق إذا كان المتخصص موجودًا
    //if (!$specialist) {
      //  return response()->json([
        //    'message' => 'Specialist not found.'
        //], 404);
   // }//

    // احذف المتخصص
    //$specialist->delete();

    //return response()->json([
      //  'message' => 'Specialist deleted successfully.'
    //], 200);
//}
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
public function registerSpecialist(Request $request)
{
    try {
        // ✅ التحقق من البيانات المدخلة
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'user_name' => 'required|string|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'birthdate' => 'nullable|date',
            'gender' => 'nullable|boolean',
            'status' => 'nullable|boolean', // قيم منطقية تأخذ 0 أو 1
            'degree' => 'required|integer',
            'specialization' => 'required|integer',
            'bio' => 'nullable|string',
            'certified' => 'nullable|boolean', // قيم منطقية تأخذ 0 أو 1
            'institution_id' => 'required|integer|exists:institutions,id',
            'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $profilePicPath = null;
        if ($request->hasFile('profile_pic')) {
            $profilePicPath = $request->file('profile_pic')->store('profile_pics', 'public');
        }
        // ✅ إنشاء المستخدم أولاً
        $user = User::create([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'user_name' => $validatedData['user_name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'birthdate' => $validatedData['birthdate'] ?? null,
            'gender' => $validatedData['gender'] ?? null,
            'status' => $validatedData['status'] ?? 0, // افتراضيًا: غير نشط (0)
            'role' => 1, // 🔥 فرض الدور كمختص
            'profile_pic_url' => $profilePicPath,
        ]);

        // ✅ إنشاء السجل في جدول `specialists`
        $specialist = Specialist::create([
            'user_id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'degree' => $validatedData['degree'],
            'specialization' => $validatedData['specialization'],
            'bio' => $validatedData['bio'] ?? null,
            'certified' => $validatedData['certified'] ?? 0, // افتراضيًا: غير معتمد (0)
            'institution_id' => $validatedData['institution_id'],
        ]);

        return response()->json([
            'message' => 'تم تسجيل المختص بنجاح!',
            'specialist' => $specialist
        ], 201);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'فشل تسجيل المختص، يرجى المحاولة مرة أخرى.',
            'details' => $e->getMessage()
        ], 500);
    }
}
public function deleteSpecialists($id)
{
    try {
        // ابحث عن المختص
        $specialist = Specialist::findOrFail($id);

        // احصل على معرف المستخدم المرتبط
        $userId = $specialist->user_id;

        // حذف المختص أولًا
        $specialist->delete();

        // حذف المستخدم المرتبط
        User::where('id', $userId)->delete();

        return response()->json([
            'message' => 'تم حذف المختص والمستخدم المرتبط به بنجاح.'
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'فشل حذف المختص.',
            'details' => $e->getMessage()
        ], 500);
    }

}
}
