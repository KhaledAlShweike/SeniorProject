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
            'gender' => 'required|in: male, female',
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

    // تسجيل الخروج
    public function logout()
{
    try {
        // إبطال صلاحية التوكن الحالي
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'Successfully logged out']);
    } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
        return response()->json(['error' => 'Invalid token'], 401);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An error occurred while logging out'], 500);
    }
}

    // تحديث التوكن
    public function refresh()
    {
        return $this->respondWithToken(JWTAuth::refresh());
    }

    // رد التوكن
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl') * 60  // استخدام ttl من إعدادات JWT
        ]);
    }

}
