<?php

namespace App\Http\Controllers;

use App\Models\Articles;
use App\Models\CategoryArticle;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    public function getDataTable(Request $request)
    {
        try {
            $baseQuery = DB::table('articles as a')
                ->join('category_articles as ca', 'a.category_id', '=', 'ca.id')
                ->whereNull('a.deleted_at')
                ->whereNull('ca.deleted_at')
                ->select('a.*', 'ca.title_en as category_name');

            $recordsTotal = $baseQuery->count();

            $query = clone $baseQuery;

            // Search
            if (!empty($request->search['value'])) {
                $search = $request->search['value'];
                $query->where(function ($q) use ($search) {
                    $q->where('a.title_en', 'like', "%{$search}%")
                        ->orWhere('ca.title_en', 'like', "%{$search}%");
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
        return view('Admin.AdminMenu.Articles.index');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $articles = $this->getDataTable($request);

            return response()->json($articles);
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
            'info_en' => "",
            'info_kh' => "",
            'description_en' => "",
            'description_kh' => "",
            'status' => 1,
            'category_id' => null,
            'category_name' => "",
            'image' => "",
            'url' => "",
            'tag' => "",
        ];
        $categories = CategoryArticle::select('id', 'title_en')->get();
        return view('Admin.AdminMenu.Articles.form', compact('data', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator($request->all(), [
                'title_en' => 'required|string|max:500',
                'title_kh' => 'required|string|max:500',
                'description_en'  => 'required|string',
                'description_kh'  => 'required|string',
                'category_id'     => 'required|exists:category_articles,id',
                'image' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json(
                    [
                        'status' => 'error',
                        'icon' => 'error',
                        'result' => $validator->getMessageBag(),
                    ],
                    422
                );
            }

            $data = $validator->validated();
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images/articles', 'public');
                $data['image'] = $imagePath;
            }

            $data['info_en'] = $request->info_en;
            $data['info_kh'] = $request->info_kh;

            $data['slug_en'] = preg_replace("/[~`{}.'\"\!\@\#\$\%\^\&\*\(\)\_\=\+\/\?\>\<\,\[\]\:\;\ \  \|\\\]/", '-', strtolower($data['title_en']));
            $data['slug_kh'] = preg_replace("/[~`{}.'\"\!\@\#\$\%\^\&\*\(\)\_\=\+\/\?\>\<\,\[\]\:\;\ \  \|\\\]/", '-', strtolower($data['title_kh']));

            $article = Articles::create($data);
            $article->image = $article->image ? asset('storage/' . $article->image) : null;

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
            $slide = Slide::find($id);

            if (!$slide) {
                return response()->json([
                    'status' => false,
                    'message' => 'Slide not found with id : ' . $id,
                ], 404);
            }

            return response()->json([
                'status' => true,
                'message' => 'Successfully get slide with id : ' . $id,
                'data' => $slide
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
        $slide = Slide::findOrFail($id);
        $slide = [
            'id' => $slide->id ?? null,
            'title_en' => $slide->title_en ?? "",
            'title_kh' => $slide->title_kh ?? "",
            'description_en' => $slide->description_en ?? "",
            'description_kh' => $slide->description_kh ?? "",
            'type' => $slide->type ?? "",
            'image' => $slide->image ?? "",
            'status' => $slide->status ?? "",
            'url' => $slide->url ?? "",
        ];
        return view('Admin.AdminMenu.Articles.form', ['data' => $slide]);
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
                'url' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);

            if ($validation->failed()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'error' => $validation->errors()
                ], 422);
            }

            $slide = Slide::find($id);

            if (!$slide) {
                return response()->json([
                    'status' => false,
                    'message' => 'Slide not found with id : ' . $id,
                ], 404);
            }

            $slide->title_en = $request->title_en;
            $slide->title_kh = $request->title_kh;
            $slide->url = $request->url;
            $slide->type = $request->type ?? $slide->type;
            $slide->status = $request->status ?? 0;

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images', 'public');
                $slide['image'] = $imagePath;
            }

            $slide->save();

            return response()->json([
                'status' => true,
                'message' => 'successfully updated slide with id : ' . $id,
                'data' => $slide
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

            $slide = Slide::find($id);

            if (!$slide) {
                return response()->json([
                    'status' => false,
                    'message' => 'Slide not found with id : ' . $id,
                ], 404);
            }

            $slide['status'] = 0;

            $slide->update();

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
