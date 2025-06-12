<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\TaskModel;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    //
    public function index()
    {
        $data['result'] = \App\Models\TaskModel::all();
        return view('task/index')->with($data);
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

        return redirect('/task')->with('success', 'Task berhasil ditambahkan.');
    }

    public function create()
    {
        $data['users'] = User::all();
        $data['projects'] = Project::all();
        return view('task/form')->with($data);
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

        return redirect('/task')->with('message', 'Data berhasil di ubah');
    }

    public function edit(string $id)
    {
        $data['result'] = TaskModel::findOrFail($id);
        $data['users'] = User::all();
        $data['projects'] = Project::all();
        return view('task/form')->with($data);
    }

    public function destroy($id)
    {
        $data = TaskModel::findOrFail($id);
        $data->delete();

        return redirect('/task')->with('success', 'Data berhasil di hapus');
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
