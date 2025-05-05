<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectMembers;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use PhpParser\Node\Stmt\TryCatch;

use function PHPUnit\Framework\returnSelf;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        try {
            // Show All Project User
            $id_user = auth('sanctum')->id();

            // find User
            $user = User::find($id_user);

            // find Project that Corelation with User
            $projects_join = $user->projectsMembers;
            $project_owner = $user->projectOwner;
            return response()->json([
                'status' => true,
                'message' => 'Succes to show project',
                'data' => [
                    'project_owner' => $project_owner,
                    'project_join' => $projects_join

                ]
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }

    }

    /**
     * Store a newly created resource in storage.
     */

    public function join(Project $project)
    {
        try {

            if (!Gate::allows('can-join', $project)) {
                return response()->json([
                    'status' => 'false',
                    'message' => 'You Is Creator this Project'
                ], 401);
            }
            // Find User Auhentication ID
            $id_user = auth('sanctum')->id();

            // Check is User Alredy join in project or not
            $user_status = ProjectMembers::where('project_id', $project->id)
                ->where('user_id', $id_user)
                ->first();


            if ($user_status) {
                return response()->json([
                    'status' => false,
                    'message' => ' User Alrady Join In The Project'
                ], 422);
            }

            // Join To Project
            ProjectMembers::create([
                'project_id' => $project->id,
                'user_id' => $id_user,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Succes Join The Project'
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'false',
                'message' => $th->getMessage()
            ], 500);

        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date'
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'false',
                'message' => 'Error : ' . $th->getMessage()
            ], 422);
        }


        $project = Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => auth('sanctum')->id(),
            'status' => 'active',
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ]);

        return response()->json($project, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        try {
            if (!Gate::allows('view-project', $project)) {
                return response()->json([
                    'status' => 'false',
                    'message' => 'not authorization denied acces this reource'
                ], 401);
            }
            return response()->json([
                'status' => 'true',
                'message' => 'succes to show data',
                'data' => $project->load([
                    'owner',
                    'members',
                    'tasks'
                ])
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'false',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        try {

            if (!Gate::allows('view-project', $project)) {
                return response()->json([
                    'status' => 'false',
                    'message' => 'not authorization denied acces this reource'
                ], 401);
            }

            try {
                $request->validate([
                    'name' => 'required|string|max:255',
                    'description' => 'required|string',
                    'status' => 'string|in:active,completed,on_hold',
                    'start_date' => 'date',
                    'end_date' => 'date||after:start_date'
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'status' => 'false',
                    'message' => $th->getMessage()
                ], 422);
            }

            $project->update($request->all());

            return response()->json([
                'status' => 'true',
                'message' => 'Update Project Succesfully',
                'data' => $project
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'false',
                'message' => $th->getMessage()
            ], 500);
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        try {

            if (!Gate::allows('view-project', $project)) {
                return response()->json([
                    'status' => 'false',
                    'message' => 'not authorization denied acces this reource'
                ], 401);
            }
            $project->delete();
            return response()->json([
                'status' => 'true',
                'message' => 'succes to delete project',
                'data' => null
            ], 204);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'false',
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
