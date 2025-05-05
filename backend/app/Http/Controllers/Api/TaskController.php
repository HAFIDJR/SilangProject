<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'false',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $project = Project::find($request->project_id);

            if (!$project) {
                return response()->json([
                    'status' => false,
                    'message' => 'Project not found'
                ], 404);
            }
            if (!Gate::allows('view-project', $project)) {
                return response()->json([
                    'status' => 'false',
                    'message' => 'not authorization denied acces this reource'
                ], 401);
            }

            try {
                $request->validate([
                    'title' => 'required|string|max:255',
                    'description' => 'required|string',
                    'project_id' => 'required|exists:projects,id',
                    'priority' => 'required|in:low,medium,hight',
                    'due_date' => 'required|date'
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'status' => 'false',
                    'message' => $th->getMessage()
                ], 403);
            }

            $task = $request->all();
            $task['user_id'] = auth('sanctum')->id();
            $task['status'] = 'todo';

            // Simpan Task 
            $task = Task::create($task);
            return response()->json([
                'status' => 'true',
                'message' => 'Project updated successfully',
                'data' => $task
            ]);


        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'false',
                'message' => $th->getMessage()
            ], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function showtask(string $id, Project $project)
    {
        try {

            if (!Gate::allows('view-task', $project)) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not authorized to view this task',
                ], 403);
            }
            $task = Task::where('id', $id)
                ->where('project_id', $project->id)
                ->first();

            if (!$task) {
                return response()->json([
                    'status' => false,
                    'message' => 'Task not found'
                ], 404);
            }

            return response()->json([
                'status' => true,
                'data' => $task
            ], 200);


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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
