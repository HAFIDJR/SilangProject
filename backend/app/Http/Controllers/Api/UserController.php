<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Nette\Schema\ValidationException as SchemaValidationException;
use PhpParser\Node\Stmt\TryCatch;

use function Pest\Laravel\json;

class UserController extends Controller
{

    public function index()
    {
        $user = User::all();
        return response()->json(
            [
                'status' => true,
                'message' => 'Data berhasil ditemukan',
                'data' => $user
            ]
        );
    }
    /**
     * Store a newly created resource in storage.
     */

    public function login(Request $request)
    {
        try {
            try {
                $request->validate([
                    'email' => 'required|email',
                    'password' => 'required'
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'status' => false,
                    'error' => $th->getMessage()
                ], 403);
            }
            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['Email or Password is Invalid'],
                ]);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'user' => $user,
                'token' => $token
            ]);
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => $th->getMessage()
                ]
                ,
                500
            );
        }

    }
    public function store(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'email' => 'required|unique:users,email',
                    'password' => 'required',
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validasi error',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Create User
            $user = $request->all();
            $user['password'] = Hash::make($request->password);
            $user = User::create($user);

            // Create token
            $token = $user->createToken('my-api')->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'user berhasil ditambahkan',
                'data' => $user,
                'toke' => $token
            ], 201);

        } catch (\Throwable $th) {

            return response()->json(
                [
                    'status' => 'error',
                    'message' => $th->getMessage()
                ]
                ,
                500
            );
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
                    'status' => 'false',
                    'message' => 'Data tidak berhasil ditemukan',
                    'data' => null
                ], 404);
            }
            return response()->json([
                'status' => 'true',
                'message' => 'Data berhasil ditemukan',
                'data' => $user
            ]);
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => $th->getMessage()
                ]
                ,
                500
            );
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {

            $data = $request->except(['_method']);
            try {
                $validator = $request->validate(
                    [
                        'name' => 'required',
                        'email' => 'required',
                        'phone_number' => 'nullable|',
                        'avatar_url' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
                    ]
                );
            } catch (\Throwable $th) {
                return response()->json([
                    'status' => false,
                    'error' => $th->getMessage()
                ], 403);
            }

            if ($request->hasFile('avatar_url')) {
                $path = $request->file('avatar_url')->store('avatars', 'public');
                $data['avatar_url'] = $path;
            }

            $user = User::find($id);
            if (!$user) {
                return response()->json([
                    'status' => 'false',
                    'message' => 'Data tidak berhasil ditemukan',
                    'data' => null
                ], 404);
            }

            $user = User::where('id', $id)->update($data);
            return response()->json([
                'status' => true,
                'message' => 'user berhasil diperbarui',
                'data' => $user
            ], 201);

        } catch (\Throwable $th) {

            return response()->json(
                [
                    'status' => 'error',
                    'message' => $th->getMessage()
                ]
                ,
                500
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find User exist or not
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'status' => 'false',
                'message' => 'Data tidak berhasil ditemukan',
                'data' => null
            ], 404);
        }

        $user->delete();
        return response()->json([
            'status' => 'true',
            'message' => 'Data Berhasil Dihapus',
            'data' => null
        ], 204);
    }
}
