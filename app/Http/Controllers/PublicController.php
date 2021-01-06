<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;
use App\Match;
use App\Fixture;

class PublicController extends Controller
{
    public function pointTable()
    {
    	$team = Team::orderBy('point', 'DESC')->orderBy('net_point', 'DESC')->get();
    	$fixture = Fixture::all();
    	
    	if(sizeof($fixture) == 0)
    	{
    		$match = 0;
    		for($ik=0; $ik<sizeof($team); $ik++)
    		{
    			$match = $match + $ik;
    		}

    		$number = array();
    		for($i=0; $i<sizeof($team); $i++)
	    	{
	    		$team1 = $team[$i]->team_name;
	    		for($j=$i+1; $j<sizeof($team); $j++)
	    		{
	    			$team2 = $team[$j]->team_name;
	    			$match_no = null;
		    		if(sizeof($number) < $match)
		    		{
		    			for(;;)
		    			{
		    				$rand1 = rand(1,$match);
		    				if(!in_array($rand1, $number))
							{
							  	$number[] = $rand1;
			    				$match_no = $rand1;
			    				break;
							}
		    			}
		    		}
	    			$create = Fixture::create([
	    				'match_no'	=> $match_no,
	    				'team1'		=> $team1,
	    				'team2'		=> $team2
	    			]);
	    		}
	    	}
    	}
    	$fixture = Fixture::orderBy('match_no', 'asc')->get();
    // 	$check = array();
    // 	$value = array();
    // 	for($i=sizeof($team)+9; $i>0; $i--)
    // 	{
    // 		for($j=0; $j<sizeof($fixture); $j = $j + $i)
    // 		{
    // 			if(!in_array($fixture[$j]->id, $check))
				// {
				//   	$check[] = $fixture[$j]->id;
    // 				$value[] = $fixture[$j];
				// }
    // 		}
    // 	}
    // 	$fixture = $value;
    	$match = Match::all();
    	return view('welcome')->with('point', $team)->with('matches', $match)->with('fixtures', $fixture);
    }
}
