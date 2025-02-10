<?php

namespace App\Http\Controllers;
use App\Models\ResearchPaper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;





class SearchController
{
    public function search(Request $request)
    {
        try {
            // إرسال الطلب إلى كود البايثون
            $response = Http::post('http://127.0.0.1:5000/search', $request->all());

            // التحقق من نجاح الاستجابة
            if (!$response->successful()) {
                return response()->json(["error" => "Failed to fetch search results from Python service"], 500);
            }

            // استخراج البيانات القادمة من كود البايثون
            $data = $response->json();

            // التأكد من وجود بيانات صالحة
            if (!isset($data) || empty($data)) {
                return response()->json(["error" => "No results found"], 404);
            }

            // استخراج جميع `pmc_id` كقائمة
            $pmcIds = collect($data)->pluck('pmc_id')->toArray();

            // البحث عن جميع الأوراق البحثية المطابقة في قاعدة البيانات
            $papers = ResearchPaper::whereIn('pmc_id', $pmcIds)->get();

            // التحقق من وجود نتائج في قاعدة البيانات
            if ($papers->isEmpty()) {
                return response()->json(["error" => "No matching research papers found"], 404);
            }

            // إرجاع جميع الأوراق البحثية كمصفوفة JSON
            return response()->json([
                "papers" => $papers
            ]);
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }
}
