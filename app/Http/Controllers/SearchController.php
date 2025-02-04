<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;





class SearchController
{
    public function search(Request $request)
    {
        // التحقق من صحة البيانات القادمة من المستخدم
        $validatedData = $request->validate([
            'text' => 'required|string',
            'imagesUrls' => 'required|array',
            'resultsType' => 'required|string',
        ]);

        // إرسال الطلب إلى خدمة البايثون Flask
        $flaskUrl = "http://127.0.0.1:5000/search"; // تأكد من أن Flask يعمل على هذا الرابط

        $response = Http::timeout(60)->post($flaskUrl, $validatedData);

        // التحقق من نجاح الطلب
        if ($response->successful()) {
            return response()->json($response->json(), 200);
        } else {
            return response()->json(['error' => 'Failed to connect to search service'], 500);
        }
    }
}
