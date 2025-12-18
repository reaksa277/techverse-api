<?php

namespace App\Http\Controllers\TechVerse;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BlogPageController extends Controller
{
    public function getAllBlogs()
    {
        try {

            $sql = "select a.* from articles a
                    join category_articles ca on a.category_id = ca.id
                    where ca.type = 'blogs' and a.deleted_at is null and a.status = 'active' and ca.deleted_at is null;";

            $blogs = DB::select($sql);

            foreach ($blogs as $blog) {
                $blog->image = asset($blog->image);
                $blog->created_at = Carbon::parse($blog->created_at)
                    ->format('M j, Y');
            }
            return response()->json([
                'status' => true,
                'message' => 'Services retrieved successfully',
                'data' => $blogs
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
