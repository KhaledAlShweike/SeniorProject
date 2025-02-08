<?php

namespace App\Http\Controllers;
use App\Models\user;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController
{

    public function register(Request $request): JsonResponse
    {
        // التحقق من البيانات
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'user_name' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'birthdate' => 'nullable|date',
            'gender' => 'required|in:0,1',
            'bio' => 'nullable|string',
            'profile_pic_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // إذا كانت الصورة موجودة
        $photoPath = null;
        if ($request->hasFile('profile_pic_url')) {
            $photoPath = $request->file('profile_pic_url')->store('profile_pics', 'public');
        }

        // حفظ بيانات المستخدم
        $user = new User();
        $user->first_name = $validatedData['first_name'];
        $user->last_name = $validatedData['last_name'];
        $user->user_name = $validatedData['user_name'];
        $user->email = $validatedData['email'];
        $user->password = Hash::make($validatedData['password']);
        $user->birthdate = $validatedData['birthdate'];
        $user->gender = $validatedData['gender'];
        $user->bio = $validatedData['bio'] ?? null;
        $user->profile_pic_url = $photoPath;  // حفظ مسار الصورة
        $user->save();

        // الاستجابة
        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
        ], 201);
    }
    public function login(Request $request)
{
    // Validate input
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string|min:6',
    ]);

    // Find user by email
    $user = User::where('email', $request->email)->first();

    // Check password
    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    // Create a new Sanctum token
    $token = $user->createToken('auth-token')->plainTextToken;

    return response()->json([
        'message' => 'Login successful',
        'user' => $user,
        'token' => $token
    ]);
}
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
    public function deleteUser($id)
{
    $user = User::find($id);

    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }

    $user->delete();

    return response()->json(['message' => 'User deleted successfully']);
}
    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);
    
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
    
        // التحقق من البيانات المدخلة فقط دون فرض القيم المطلوبة
        $validatedData = $request->validate([
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'user_name' => 'nullable|string|max:255|unique:users,user_name,' . $id,
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'birthdate' => 'nullable|date',
            'gender' => 'nullable|in:0,1',
            'bio' => 'nullable|string',
            'profile_pic_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // تحديث الحقول فقط إذا تم إرسالها في الطلب
        if ($request->filled('first_name')) $user->first_name = $validatedData['first_name'];
        if ($request->filled('last_name')) $user->last_name = $validatedData['last_name'];
        if ($request->filled('user_name')) $user->user_name = $validatedData['user_name'];
        if ($request->filled('email')) $user->email = $validatedData['email'];
        if ($request->filled('password')) $user->password = Hash::make($validatedData['password']);
        if ($request->filled('birthdate')) $user->birthdate = $validatedData['birthdate'];
        if ($request->filled('gender')) $user->gender = $validatedData['gender'];
        if ($request->filled('bio')) $user->bio = $validatedData['bio'];
    
        // تحديث الصورة الشخصية إذا تم رفعها
        if ($request->hasFile('profile_pic_url')) {
            $photoPath = $request->file('profile_pic_url')->store('profile_pics', 'public');
            $user->profile_pic_url = $photoPath;
        }
    
        $user->save();
    
        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }
    




    // تحديث التوكن
    public function refresh()
    {
        return $this->respondWithToken(JWTAuth::refresh(JWTAuth::getToken()));
    }

    // رد التوكن
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60

        ]);
    }

}
