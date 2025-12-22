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
            $query = Slide::query()
                ->where('deleted_at', '=', null);

            // Search
            if ($request->has('search') && !empty($request->search['value'])) {
                $searchValue = $request->search['value'];
                $query->where(function ($q) use ($searchValue) {
                    $q->where('slides.title_kh', 'like', "%$searchValue%")
                        ->orWhere('slides.title_en', 'like', "%$searchValue%");
                });
            }

            $total = $query->count();
            $req_order = $request->order;

            // Sorting
            if (isset($req_order)) {
                $sortColumn = $request->columns[$req_order[0]['column']]['name'];
                $sortDirection = $req_order[0]['dir'];
                if ($sortColumn && $sortDirection) {
                    $query->orderBy($sortColumn, $sortDirection);
                }
            }

            // Pagination
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);
            $query->skip($start)->take($length);

            $data = $query->get();

            return [
                'draw' => $request->input('draw', 1),
                'recordsTotal' => $total,
                'recordsFiltered' => $total,
                'data' => $data
            ];
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
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

            Log::debug("slide info: ", ["slide"=>$slides]);

            return response()->json([
                'status' => true,
                'message' => 'Slides retrieved successfully',
                'data' => $slides
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
                'tilte_kh' => 'required|string|max:500',
                'url' => 'required|string|max:255',
            ]);

            if ($validation->failed()) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Validation error',
                        'error' => $validation->errors()
                    ],
                    422
                );
            }

            $slide = Slide::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'created slide successfullly',
                'data' => $slide
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
