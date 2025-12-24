<?php

namespace App\Http\Controllers;

use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use function Laravel\Prompts\error;

class SlideController extends Controller
{
    public function getDataTable(Request $request)
    {
        try {
            $baseQuery = Slide::whereNull('deleted_at');

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
        return view('Admin.AdminMenu.Slides.index');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $slides = $this->getDataTable($request);

            return response()->json($slides);
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
        return view('Admin.AdminMenu.Slides.form');
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

            Slide::create($request->all());
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
                'tilte_kh' => 'required|string|max:500',
                'url' => 'required|string|max:255',
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

            $slide->update($request->all());

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

            Log::debug("slide info: ", ["slide" => $slide]);

            if (!$slide) {
                return response()->json([
                    'status' => false,
                    'message' => 'Slide not found with id : ' . $id,
                ], 404);
            }

            $slide->delete();

            return response()->json([
                'status' => true,
                'message' => 'successfully deleted slide'
            ], 204);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
