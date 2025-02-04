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
        // التحقق من المدخلات
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // الحصول على بيانات الاعتماد من الطلب
        $credentials = $request->only('email', 'password');

        // التحقق من وجود المستخدم
        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // إنشاء التوكن باستخدام JWT
        $token = JWTAuth::attempt($credentials);

        if (!$token) {
            return response()->json(['error' => 'Could not create token'], 500);
        }

        // استجابة مع التوكن
        return $this->respondWithToken($token);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
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
