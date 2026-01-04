<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function getDataTable(Request $request)
    {
        try {
            $baseQuery = User::where('status', 1);

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
            'password' => "",
            'role' => "",
            'image' => "",
            'status' => "",
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
                // 'image' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);

            if ($validation->fails()) {
                return response()->json(
                    [
                        'status' => 'error',
                        'icon' => 'error',
                        'result' => $validation->getMessageBag(),
                    ],
                    422
                );
            }

            $imagePath = null;

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')
                    ->store('images/users', 'public');
            }

            $data = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'image' => $imagePath,
            ]);

            $data->image = $data->image ? asset('storage/' . $data->image) : null;

            return response()->json([
                'status' => 'success',
                'icon' => 'success',
                'message' => 'created user successfullly',
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
        $user = User::findOrFail($id);
        $user = [
            'id' => $user->id ?? null,
            'name' => $user->name ?? "",
            'email' => $user->email ?? "",
            'password' => $user->password ?? "",
            'role' => $user->role ?? "",
            'image' => $user->image ?? "",
            'status' => $user->status ?? "",
        ];
        return view('Admin.AdminMenu.Users.form', ["data" => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        try {

            $validation = Validator($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8',
                'role' => 'required|in:admin,user',
                'image' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);

            if ($validation->failed()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'error' => $validation->errors()
                ], 422);
            }

            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found with id : ' . $id,
                ], 404);
            }
            // Update fields
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->status = $request->has('status') ? $request->status : $user->status;

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images/users', 'public');
                $user->image = $imagePath;
            }

            $user->save();

            $user->image = $user->image ? asset('storage/' . $user->image) : null;

            return response()->json([
                'status' => true,
                'message' => 'successfully updated user with id : ' . $id,
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {

            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'user not found with id : ' . $id,
                ], 404);
            }

            $user['status'] = 0;

            $user->update();

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
