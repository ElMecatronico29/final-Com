<?php

namespace App\Http\Controllers;
use App\Events\RaceStarted;
use App\Events\RaceCreate;
use App\Events\RaceUpdate;
use App\Events\RaceUpdateMove;
use App\Events\RaceJoin;
use App\Events\RaceEnded;
use App\Events\endGame;
use App\Models\Race;
use Illuminate\Http\Request;

class RaceController extends Controller
{
    public function create(Request $request)
    {
        try {
            $race = Race::create([
                'start_time' => now(),
                'creator' => $request->input('creator'),
                'jugadorActual' => $request->input('creator'),
                'players' => json_encode([$request->input('creator')]),
                'started'=> false,
                'endGame'=> false
            ]);            
            broadcast(new RaceCreate($race->start_time, $race->creator, $race->players));
            return response()->json($race);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al iniciar la carrera'], 500);
        }
    }
    public function join(Request $request)
    {
        $race = Race::where('started', false)->where('endGame', false)->first();   
        
        $players = json_decode($race->players, true);
        $players[] = $request->input('player');
        $race->players = json_encode($players);
        $race->update();
        broadcast(new RaceJoin($race->start_time, $race->creator, $race->players));
        return response()->json($race);
    }
    public function start(Request $request)
    {
        $race = Race::where('started', false)->where('endGame', false)->first();      
        $race->started = true; 
        $race->update();           
        broadcast(new RaceStarted(now(),$request->input('creator')));
        return ;
    }
    public function transport(Request $request)
    {
        $race = Race::where('started', true)->where('endGame', false)->firstOrFail();
        $race->jugadorActual = $request->input('playerName');
        $race->update();
        broadcast(new RaceUpdate($race->jugadorActual));
        return response()->json($race); 
    }
    public function move()
    {        
        RaceUpdateMove::dispatch();
        //broadcast(new RaceUpdateMove());
        return ; 
    }
    public function endGame()
    {   
        $race = Race::where('started', true)->where('endGame', false)->firstOrFail();
        $race->endGame = true;
        $race->update();     
        broadcast(new endGame());
        return ; 
    }

    public function end(Race $race)
    {
        $race->update(['end_time' => now()]);
        broadcast(new RaceEnded($race));
        return response()->json($race);
    }
}
