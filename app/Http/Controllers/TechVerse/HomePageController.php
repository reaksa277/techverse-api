<?php

namespace App\Http\Controllers\TechVerse;

use App\Http\Controllers\Controller;
use App\Models\Articles;
use App\Models\CategoryArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HomePageController extends Controller
{
    public function getServices()
    {
        try {

            $sql = "select a.* from articles a join category_articles ca on a.category_id = ca.id
                    where ca.type = 'services' and a.deleted_at is null and a.status = 'active' and ca.deleted_at is null;";        

            $services = DB::select($sql);

            return response()->json([
                'status' => true,
                'message' => 'Services retrieved successfully',
                'data' => $services
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
