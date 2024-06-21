<?php

namespace App\Http\Controllers;
use App\Models\Game;

use Illuminate\Http\Request;

class GameController extends Controller
{
    public function create(Request $request)
    {
        $game = Game::create([
            'name' => $request->input('name'),
            'creator' => $request->input('creator'),
            'players' => json_encode([$request->input('creator')]) // Cambiar con id o algo porque los nombres se pueden repetir
        ]);

        return response()->json($game);
    }
    public function join(Request $request, $id)
    {
        $game = Game::find($id);
        if (!$game) {
            return response()->json(['message' => 'Game not found'], 404);
        }
        
        $players = json_decode($game->players, true);
        $players[] = $request->input('username');
        $game->players = json_encode($players);
        $game->save();
        return response()->json($game);
    }

}
