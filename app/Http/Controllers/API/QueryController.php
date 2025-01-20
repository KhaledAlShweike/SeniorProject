<?php

namespace App\Http\Controllers;

use App\Models\Query;
use App\Models\MedicalRecord;
use App\Models\ResearchPaper;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class QueryController extends Controller
{
    public function submitQuery(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:text,image,voice',
            'content' => 'required|json',
        ]);

        $query = Query::create([
            'type' => $data['type'],
            'content' => $data['content'],
            'status' => 'received',
        ]);

        return response()->json(["message" => "Query received", "query_id" => $query->id], 200);
    }

    public function processQuery($query_id)
    {
        $query = Query::find($query_id);

        if (!$query) {
            return response()->json(["error" => "Query not found"], 404);
        }

        $ai_response = app('ai_system')->process($query->type, $query->content);

        $query->update([
            'status' => 'processed',
            'results' => json_encode($ai_response),
        ]);

        return response()->json(["message" => "Query processed", "results" => $ai_response], 200);
    }

    public function getResults($query_id)
    {
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
    }
}

class HealthRecordController extends Controller
{
    public function storeRecord(Request $request)
    {
        $data = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'specialist_id' => 'required|exists:specialists,id',
            'diagnosis' => 'required|string',
            'treatment_plan' => 'nullable|string',
        ]);

        $record = MedicalRecord::create([
            'patient_id' => $data['patient_id'],
            'specialist_id' => $data['specialist_id'],
            'diagnosis' => $data['diagnosis'],
            'treatment_plan' => $data['treatment_plan'],
            'status' => 'stored',
        ]);

        return response()->json(["message" => "Record stored", "record_id" => $record->id], 200);
    }

    public function getRecords($patient_id)
    {
        $records = MedicalRecord::where('patient_id', $patient_id)->get();

        if ($records->isEmpty()) {
            return response()->json(["error" => "No records found"], 404);
        }

        return response()->json(["patient_id" => $patient_id, "records" => $records], 200);
    }
}

?>
