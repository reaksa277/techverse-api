<?php

namespace App\Http\Controllers;

use App\Models\CategoryArticle;
use App\Models\Slide;
use Illuminate\Http\Request;

class CategoryArticleController extends Controller
{
    public function getDataTable(Request $request)
    {
        try {
            $baseQuery = CategoryArticle::whereNull('deleted_at')->where('status', 1);

            $recordsTotal = $baseQuery->count();

            $query = clone $baseQuery;

            // Search
            if ($request->has('search') && !empty($request->search['value'])) {
                $searchValue = $request->search['value'];
                $query->where(function ($q) use ($searchValue) {
                    $q->where('title_kh', 'like', "%$searchValue%")
                        ->orWhere('title_en', 'like', "%$searchValue%")
                        ->orWhere('type', 'like', "%$searchValue%");
                });
            }

            $recordsFiltered = $query->count();

            // Sorting
            if ($request->has('order')) {
                $orderColumnIndex = $request->order[0]['column'];
                $orderDirection   = $request->order[0]['dir'];

                $orderColumn = $request->columns[$orderColumnIndex]['data'];

                if (!empty($orderColumn)) {
                    $query->orderBy($orderColumn, $orderDirection);
                }
            }

            // Pagination
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);
            $query->skip($start)->take($length);

            $data = $query->get();

            return [
                'draw' => $request->input('draw', 1),
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $data
            ];
        } catch (\Exception $e) {
            return response()->json([
                'draw' => intval($request->draw),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
            ], 500);
        }
    }
    public function view()
    {
        return view('Admin.AdminMenu.CategoryArticles.index');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $category_articles = $this->getDataTable($request);

            return response()->json($category_articles);
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
        $data = [
            'id' => null,
            'title_en' => "",
            'title_kh' => "",
            'description_en' => "",
            'description_kh' => "",
            'type' => "",
            'image' => "",
            'status' => "",
            'url' => "",
        ];
        return view('Admin.AdminMenu.CategoryArticles.form', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validation = Validator($request->all(), [
                'title_en' => 'required|string|max:500',
                'tilte_kh' => 'required|string|max:500',
                'image' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);

            if ($validation->failed()) {
                return response()->json(
                    [
                        'status' => 'error',
                        'icon' => 'error',
                        'result' => $validation->getMessageBag(),
                    ],
                    422
                );
            }

            $data = $request->all();

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images', 'public');
                $data['image'] = $imagePath;
            }
            $category_article = CategoryArticle::create($data);

            $category_article->image = $category_article->image ? asset('storage/' . $category_article->image) : null;

            return response()->json([
                'status' => 'success',
                'icon' => 'success',
                'message' => 'created slide successfullly',
                'data' => $this->getDataTable($request),
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
        try {
            $category_article = CategoryArticle::find($id);

            if (!$category_article) {
                return response()->json([
                    'status' => false,
                    'message' => 'Slide not found with id : ' . $id,
                ], 404);
            }

            return response()->json([
                'status' => true,
                'message' => 'Successfully get Category Article with id : ' . $id,
                'data' => $category_article
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
        $category_article = CategoryArticle::findOrFail($id);
        $category_article = [
            'id' => $category_article->id ?? null,
            'title_en' => $category_article->title_en ?? "",
            'title_kh' => $category_article->title_kh ?? "",
            'description_en' => $category_article->description_en ?? "",
            'description_kh' => $category_article->description_kh ?? "",
            'type' => $category_article->type ?? "",
            'image' => $category_article->image ?? "",
            'status' => $category_article->status ?? "",
            'url' => $category_article->url ?? "",
        ];
        return view('Admin.AdminMenu.CategoryArticles.form', ['data' => $category_article]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        try {

            $validation = Validator($request->all(), [
                'title_en' => 'required|string|max:500',
                'tilte_kh' => 'required|string|max:500',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);

            if ($validation->failed()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'error' => $validation->errors()
                ], 422);
            }

            $category_article = CategoryArticle::find($id);

            if (!$category_article) {
                return response()->json([
                    'status' => false,
                    'message' => 'category_article not found with id : ' . $id,
                ], 404);
            }

            $category_article->title_en = $request->title_en;
            $category_article->title_kh = $request->title_kh;
            $category_article->description_en = $request->description_en;
            $category_article->description_kh = $request->description_kh;
            $category_article->type = $request->type ?? $category_article->type;
            $category_article->status = $request->status ?? 0;

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images', 'public');
                $category_article['image'] = $imagePath;
            }

            $category_article->save();

            return response()->json([
                'status' => true,
                'message' => 'successfully updated category_article with id : ' . $id,
                'data' => $category_article
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

            $category_article = CategoryArticle::find($id);

            if (!$category_article) {
                return response()->json([
                    'status' => false,
                    'message' => 'category_article not found with id : ' . $id,
                ], 404);
            }

            $category_article['status'] = 0;

            $category_article->update();
            $category_article->delete();

            return response()->json([
                'status' => true,
                'message' => 'Slide deleted successfully'
            ], 204);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
