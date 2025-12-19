<?php

namespace App\Http\Controllers\TechVerse;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CaseStudyController extends Controller
{
    public function getCaseStudies()
    {
        try {

            $sql = "select a.* from articles a
                    join category_articles ca on a.category_id = ca.id
                    where ca.type = 'case_study' and a.deleted_at is null and a.status = 'active' and ca.deleted_at is null;";

            $case_studies = DB::select($sql);

            foreach ($case_studies as $case_study) {
                $case_study->image = asset($case_study->image);
                $case_study->created_at = Carbon::parse($case_study->created_at)
                    ->format('M j, Y');
            }
            return response()->json([
                'status' => true,
                'message' => 'Services retrieved successfully',
                'data' => $case_studies
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
