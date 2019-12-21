<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;
use App\Match;

class PublicController extends Controller
{
    public function pointTable()
    {
    	$team = Team::orderBy('point', 'DESC')->orderBy('net_point', 'DESC')->get();
    	$match = Match::all();
    	return view('welcome')->with('point', $team)->with('matches', $match);
    }
}
