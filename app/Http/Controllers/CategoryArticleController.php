<?php

namespace App\Http\Controllers;


use App\Models\CategoryArticle;
use Illuminate\Http\Request;

class CategoryArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category_articles = CategoryArticle::all();

        return response()->json([
            'status' => true,
            'message' => 'Slides retrieved successfully',
            'data' => $category_articles
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $validation = Validator($request->all(), [
                'title_en' => 'required|string|max:500',
                'title_kh' => 'required|string|max:500',
                'url' => 'required|string|max:255',
                'type' => 'required|string|max:255',
            ]);

            if ($validation->failed()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'error' => $validation->errors(),
                ]);
            }

            $category_articles = CategoryArticle::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'created category articles successfullly',
                'data' => $category_articles
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category_articles = CategoryArticle::find($id);

        if (!$category_articles) {
            return response()->json([
                'status' => false,
                'message' => 'Category Article not found with id : ' . $id,
            ], 404);
        }

        return response()->json([
            'status' => false,
            'message' => 'Successfully retrieved Category Article with id : ' . $id,
            'data' => $category_articles
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validation = Validator($request->all(), [
                'title_en' => 'required|string|max:500',
                'title_kh' => 'required|string|max:500',
                'url' => 'required|string|max:255',
                'type' => 'required|string|max:255',
            ]);

            if ($validation->failed()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'error' => $validation->errors(),
                ]);
            }

            $category_articles = CategoryArticle::find($id);

            $category_articles->update($request->all());
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
