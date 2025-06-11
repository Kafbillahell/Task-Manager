<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    // GET /api/teams
    public function index()
    {
        return response()->json(Team::all());
    }

    // POST /api/teams
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $team = Team::create($validated);
        return response()->json($team, 201);
    }

    // GET /api/teams/{team}
    public function show(Team $team)
    {
        return response()->json($team);
    }

    // PUT /api/teams/{team}
    public function update(Request $request, Team $team)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $team->update($validated);
        return response()->json($team);
    }

    // DELETE /api/teams/{team}
    public function destroy(Team $team)
    {
        $team->delete();
        return response()->json(null, 204);
    }
}
