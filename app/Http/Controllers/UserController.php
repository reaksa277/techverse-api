<?php

namespace App\Http\Controllers;

use App\Models\Slide;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getDataTable(Request $request)
    {
        try {
            $baseQuery = User::whereNull('deleted_at')->where('status', 1);

            $recordsTotal = $baseQuery->count();

            $query = clone $baseQuery;

            // Search
            if ($request->has('search') && !empty($request->search['value'])) {
                $searchValue = $request->search['value'];
                $query->where(function ($q) use ($searchValue) {
                    $q->where('name', 'like', "%$searchValue%")
                        ->orWhere('email', 'like', "%$searchValue%");
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
            dd($data);

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
        return view('Admin.AdminMenu.Users.index');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Log::debug('DataTables request:', $request->all());
        try {
            $user = $this->getDataTable($request);

            return response()->json($user);
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
            'name' => "",
            'email' => "",
            'role' => "",
            'status' => "",
            'image' => "",
        ];
        return view('Admin.AdminMenu.Users.form', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validation = Validator($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8',
                'role' => 'required|in:admin,user',
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
            $data = User::create($data);

            $data->image = $data->image ? asset('storage/' . $data->image) : null;

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
            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found with id : ' . $id,
                ], 404);
            }

            return response()->json([
                'status' => true,
                'message' => 'Successfully get user with id : ' . $id,
                'data' => $user
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
        return view('Admin.AdminMenu.Users.form',);
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
