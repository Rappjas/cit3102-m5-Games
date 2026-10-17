<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index(Request $request)
    {
        $allowed = ['genre', 'platform', 'release_year'];
        $query = Game::query();

        foreach ($allowed as $field) {
            if ($request->filled($field)) {
                $query->where($field, $request->query($field));
            }
        }

        return response()->json($query->get(), 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'genre'        => 'required|string|max:100',
            'platform'     => 'required|string|max:100',
            'price'        => 'required|numeric|min:0',
            'release_year' => 'required|integer|min:1970|max:2100',
        ]);

        return response()->json(Game::create($data), 201);
    }

    public function show(Game $game)
    {
        return response()->json($game, 200);
    }

    public function update(Request $request, Game $game)
    {
        $data = $request->validate([
            'title'        => 'sometimes|required|string|max:255',
            'genre'        => 'sometimes|required|string|max:100',
            'platform'     => 'sometimes|required|string|max:100',
            'price'        => 'sometimes|required|numeric|min:0',
            'release_year' => 'sometimes|required|integer|min:1970|max:2100',
        ]);

        $game->update($data);
        return response()->json($game, 200);
    }

    public function destroy(Game $game)
    {
        $game->delete();
        return response()->noContent(); // 204
    }
}