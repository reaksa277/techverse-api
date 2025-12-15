<?php

namespace App\Http\Controllers;

use App\Models\Articles;
use App\Models\CategoryArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $articles = Articles::all();

            return response()->json([
                'status' => true,
                'message' => 'Articles retrieved successfully',
                'data' => $articles
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
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
                'description_en' => 'required|string',
                'description_kh' => 'required|string',
                'info_en' => 'required|string|max:500',
                'info_kh' => 'required|string|max:500',
                'category_id' => 'required|exists:category_articles,id',
            ]);

            if ($validation->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validation->errors(),
                ], 422);
            }

            $data = $request->all();
            $data['slug_en'] = preg_replace("/[~`{}.'\"\!\@\#\$\%\^\&\*\(\)\_\=\+\/\?\>\<\,\[\]\:\;\ \  \|\\\]/", '-', strtolower($data['title_en']));
            $data['slug_kh'] = preg_replace("/[~`{}.'\"\!\@\#\$\%\^\&\*\(\)\_\=\+\/\?\>\<\,\[\]\:\;\ \  \|\\\]/", '-', strtolower($data['title_kh']));

            Articles::create($data);

            return response()->json([
                'status' => true,
                'message' => 'Article created successfully',
                'data' => $data
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while creating the article.', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $article = Articles::find($id);

            if(!$article) {
                return response()->json([
                    'status' => false,
                    'message' => 'Article not found',
                ], 404);
            }

            return response()->json([
                'status' => true,
                'message' => 'Article retrieved successfully with id : ' . $id,
                'data' => $article
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
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
            $article = Articles::find($id);

            if(!$article) {
                return response()->json([
                    'status' => false,
                    'message' => 'Article not found',
                ], 404);
            }

            $validation = Validator($request->all(), [
                'title_en' => 'sometimes|required|string|max:500',
                'title_kh' => 'sometimes|required|string|max:500',
                'description_en' => 'sometimes|required|string',
                'description_kh' => 'sometimes|required|string',
                'info_en' => 'sometimes|required|string|max:500',
                'info_kh' => 'sometimes|required|string|max:500',
                'category_id' => 'sometimes|required|exists:category_articles,id',
            ]);

            if ($validation->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validation->errors(),
                ], 422);
            }

            $article->update($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Article updated successfully',
                'data' => $article
            ], 200);
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
        try {
            $article = Articles::find($id);

            if(!$article) {
                return response()->json([
                    'status' => false,
                    'message' => 'Article not found',
                ], 404);
            }

            $article->delete();

            return response()->json([
                'status' => true,
                'message' => 'Article deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
