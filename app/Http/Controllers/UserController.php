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
            'gender' => 'required|boolean',
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
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    // تسجيل الخروج
    public function logout(Request $request): JsonResponse
    {
        try {
            // الحصول على التوكن المرسل مع الطلب
            $token = JWTAuth::getToken();

            // التحقق من وجود التوكن
            if (!$token) {
                return response()->json(['error' => 'Token not provided'], 400);
            }

            // إلغاء صلاحية التوكن
            JWTAuth::invalidate($token);

            // إرسال استجابة بنجاح عملية تسجيل الخروج
            return response()->json(['message' => 'Successfully logged out']);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['error' => 'Invalid token'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['error' => 'Token expired'], 401);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to logout, please try again'], 500);
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





    ////////////////////////////////////للاطلاع غدا


    <?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Query;
use App\Models\MedicalRecord;
use App\Models\ResearchPaper;

// 1. Endpoint for receiving user input (Text, Image, Voice)
Route::post('/api/submit_query', function (Request $request) {
    $data = $request->validate([
        'type' => 'required|string',
        'content' => 'required|string',
    ]);

    $query = Query::create([
        'type' => $data['type'],
        'content' => $data['content'],
        'status' => 'received',
    ]);

    return response()->json(["message" => "Query received", "query_id" => $query->id], 200);
});

// 2. Endpoint to process the query (Interfacing with AI system)
Route::post('/api/process_query/{query_id}', function ($query_id) {
    $query = Query::find($query_id);

    if (!$query) {
        return response()->json(["error" => "Query not found"], 404);
    }

    // Mock AI processing logic
    $ai_response = app('ai_system')->process($query->type, $query->content);

    $query->update([
        'status' => 'processed',
        'results' => json_encode($ai_response),
    ]);

    return response()->json(["message" => "Query processed", "results" => $ai_response], 200);
});

// 3. Endpoint to aggregate results (Compile and return to front-end)
Route::get('/api/get_results/{query_id}', function ($query_id) {
    $query = Query::find($query_id);

    if (!$query || $query->status !== 'processed') {
        return response()->json(["error" => "Results not ready"], 404);
    }

    $related_papers = ResearchPaper::where('keywords', 'like', '%' . $query->content . '%')->get();

    return response()->json([
        "query_id" => $query_id,
        "results" => json_decode($query->results, true),
        "related_papers" => $related_papers,
    ], 200);
});

// 4. Endpoint to store health records
Route::post('/api/store_record', function (Request $request) {
    $data = $request->validate([
        'patient_id' => 'required|integer',
        'doctor_id' => 'required|integer',
        'diagnosis' => 'required|string',
        'treatment_plan' => 'nullable|string',
    ]);

    $record = MedicalRecord::create([
        'patient_id' => $data['patient_id'],
        'doctor_id' => $data['doctor_id'],
        'diagnosis' => $data['diagnosis'],
        'treatment_plan' => $data['treatment_plan'],
        'status' => 'stored',
    ]);

    return response()->json(["message" => "Record stored", "record_id" => $record->id], 200);
});

// 5. Endpoint to retrieve health records
Route::get('/api/get_records/{patient_id}', function ($patient_id) {
    $records = MedicalRecord::where('patient_id', $patient_id)->get();

    if ($records->isEmpty()) {
        return response()->json(["error" => "No records found"], 404);
    }

    return response()->json(["patient_id" => $patient_id, "records" => $records], 200);
});

?>

}
