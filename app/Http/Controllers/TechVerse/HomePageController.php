<?php

namespace App\Http\Controllers\TechVerse;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class HomePageController extends Controller
{
    public function getSlides()
    {
        try {

            $sql = "select * from slides s
                    where s.type = 'banner';";

            $slides = DB::select($sql);
            foreach ($slides as $slide) {
                $slide->image = asset($slide->image);
            }
            return response()->json([
                'status' => true,
                'message' => 'Services retrieved successfully',
                'data' => $slides
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
    public function getServices()
    {
        try {

            $sql = "select a.*, ca.image as category_image from articles a
                    join category_articles ca on a.category_id = ca.id
                    where ca.type = 'services' and a.deleted_at is null and a.status = 1 and ca.deleted_at is null;";

            $services = DB::select($sql);
            foreach ($services as $service) {
                $service->category_image = asset($service->category_image);
            }
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

    public function getBlogs()
    {
        try {
            $sql = "select a.* from articles a
                    join category_articles ca on a.category_id = ca.id
                    where ca.type = 'blogs' and a.deleted_at is null and a.status = 'active' and ca.deleted_at is null limit 3;";

            $blogs = DB::select($sql);
            foreach ($blogs as $blog) {
                $blog->image = asset($blog->image);
            }
            return response()->json([
                'status' => true,
                'message' => 'Blogs retrieved successfully',
                'data' => $blogs
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function getDetailArticle(string $id)
    {
        try {
            $sql = "select a.* from articles a where id = $id";

            $detail_articles = DB::select($sql);
            foreach ($detail_articles as $detail_article) {
                $detail_article->image = asset($detail_article->image);
            }

            return response()->json([
                'status' => true,
                'message' => 'Blogs retrieved successfully',
                'data' => $detail_article
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function getCaseStudies()
    {
        try {
            $sql = "select a.* from articles a
                    join category_articles ca on a.category_id = ca.id
                    where ca.type = 'case_study' and a.deleted_at is null and a.status = 1 and ca.deleted_at is null limit 1;";

            $caseStudies = DB::select($sql);
            foreach ($caseStudies as $caseStudy) {
                $caseStudy->image = asset($caseStudy->image);
            }
            return response()->json([
                'status' => true,
                'message' => 'Case Studies retrieved successfully',
                'data' => $caseStudies
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function getAdvertisement()
    {
        try {

            $sql = "select * from slides s
                    where s.type = 'advertisement';";

            $advertisement = DB::select($sql);

            return response()->json([
                'status' => true,
                'message' => 'Advertisement retrieved successfully',
                'data' => $advertisement,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
