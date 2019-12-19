<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Match;
use App\Team;
use App\Player;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $match = Match::all();
        $team = Team::all();
        $player = Player::all();
        return view('home')->with('matchs', $match)->with('teams', $team)->with('players', $player);
    }
}
