<?php

namespace App\Http\Controllers;

use App\Models\TaskModel;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    //
    public function index()
    {
        return TaskModel::all();

    }

    public function store(Request $request)
    {
        $request->validate([
            'title' =>  'required|max:100',
            'description' => 'required|max:100',
            'project_id' => 'required|integer',
            'assigned_to' => 'required|integer',
            'created_by' => 'required',
            'status' => 'required',
            'order' => 'required|integer',
            'likes_count' => 'required|integer'
        ]);

        $data = TaskModel::create($request->all());

        return response()->json($data, 201);
    }

    public function show($id)
    {
        $data = TaskModel::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $data = TaskModel::findOrFail($id);

        $request->validate([
            'title' =>  'required|max:100',
            'description' => 'required|max:100',
            'project_id' => 'required|integer',
            'assigned_to' => 'required|integer',
            'created_by' => 'required',
            'status' => 'required',
            'order' => 'required|integer',
            'likes_count' => 'required|integer'
        ]);

        $data->update($request->all());

        return response()->json($data);
    }

    public function destroy($id)
    {
        $data = TaskModel::findOrFail($id);
        $data->delete();

        return response()->json(['message' => 'Task Berhasil di hapus ']);
    }
    public function showBoard()
    {
        $todoTasks = TaskModel::where('status', 'todo')->get();
        $inProgressTasks = TaskModel::where('status', 'in_progress')->get();
        $doneTasks = TaskModel::where('status', 'done')->get();

        return view('tasks.tasks', compact('todoTasks', 'inProgressTasks', 'doneTasks'));
    }
    public function updateStatus(Request $request, $id)
    {
        $task = TaskModel::findOrFail($id);
        $request->validate([
            'status' => 'required|in:todo,in_progress,done',
            'order' => 'required|integer'
        ]);
        $task->status = $request->status;
        $task->order = $request->order;
        $task->save();
    
        return response()->json(['success' => true]);
    }
}
