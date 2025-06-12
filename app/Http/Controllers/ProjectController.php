<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $data['result'] = \App\Models\Project::all();
        return view('project/index')->with($data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'team_id' => 'required|integer',
            'created_by' => 'required|integer',
        ]);

        $project = Project::create($request->all());

        return redirect('/project')->with('success', 'Project berhasil ditambahkan.');
    }

    public function create()
    {
        return view('project/form');
    }

    public function show($id)
    {
        $project = Project::findOrFail($id);
        return response()->json($project);
    }

    public function edit(string $id)
    {
        //
        $data['result'] = \App\Models\Project::where('id', $id)->first();
        return view('project/form')->with($data);
    }

    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'team_id' => 'sometimes|required|integer',
            'created_by' => 'sometimes|required|integer',
        ]);

        $project->update($request->all());
        return redirect('/project')->with('message', 'Data berhasil di ubah');

       
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return redirect('/project')->with('success', 'Project berhasil dihapus.');
    }
}
