<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Match;
use App\Team;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class MatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('match.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'team_1_id'     => ['required', 'integer'],
            'team_1_point'  => ['required', 'integer', 'min:0', 'max:15'],
            'team_2_id'     => ['required', 'integer'],
            'team_2_point'  => ['required', 'integer', 'min:0', 'max:15'],
        ]);
        if($data)
        {
            $check_1 = Match::where('team_1_id', $data['team_1_id'])->where('team_2_id', $data['team_2_id'])->first();

            $check_2 = Match::where('team_1_id', $data['team_2_id'])->where('team_2_id', $data['team_1_id'])->first();

            if($check_1 || $check_2)
            {
                return 'match_done';
            }

            $net_point = number_format(0 , 0);
            $result = "";

            if($data['team_1_id'] == $data['team_2_id'])
            {
                return "same_team";
            }

            if($data['team_1_point'] == $data['team_2_point'])
            {
                return "same_point";
            }

            $t1 = Team::find($data['team_1_id']);
            $data['team_1'] = $t1->team_name;

            $t2 = Team::find($data['team_2_id']);
            $data['team_2'] = $t2->team_name;

            if($data['team_1_point'] > $data['team_2_point'])
            {
                if (!($data['team_1_point'] == 10 || $data['team_1_point'] == 15)) 
                {
                    return 'invalid_score';
                }

                if($data['team_1_point'] == 10)
                {
                    $net_point = ( number_format($data['team_1_point'], 2) - number_format($data['team_2_point'], 2)  + 5) /100;

                    $result = $data['team_1'] . " win by " . $data['team_1_point'] . " - " . $data['team_2_point'];
                }
                elseif($data['team_1_point'] == 15)
                {
                    $net_point =  (number_format($data['team_1_point'], 2) - number_format($data['team_2_point'], 2)) /100;

                    $result = $data['team_1'] . " win by " . $data['team_1_point'] . " - " . $data['team_2_point'];
                }

                $t1_update = Team::where('id', $t1->id)->update([
                    'played'        => $t1->played + 1,
                    'win'           => $t1->win + 1,
                    'point'         => $t1->point + 2,
                    'net_point'     => number_format(($t1->net_point + $net_point), 2)
                ]);

                $t2_update = Team::where('id', $t2->id)->update([
                    'played'        => $t2->played + 1,
                    'lose'          => $t2->lose + 1,
                    'net_point'     => number_format(($t2->net_point - $net_point), 2)
                ]);
            }
            else
            {
                if(!($data['team_2_point'] == 10 || $data['team_2_point'] == 15))
                {
                    return 'invalid_score';
                }

                if($data['team_2_point'] == 10)
                {
                    $net_point = (( number_format($data['team_2_point'], 2) - number_format($data['team_2_point'],2) ) + 5) /100;
                    $result = $data['team_2'] . " win by " . $data['team_2_point'] . " - " . $data['team_1_point'];
                }
                elseif($data['team_2_point'] == 15)
                {
                    $net_point = ( number_format($data['team_2_point'], 2) - number_format($data['team_1_point'],2) )/100;
                    $result = $data['team_2'] . " win by " . $data['team_2_point'] . " - " . $data['team_1_point'];
                }

                $t2_update = Team::where('id', $t2->id)->update([
                    'played'        => $t2->played + 1,
                    'win'           => $t2->win + 1,
                    'point'         => $t2->point + 2,
                    'net_point'     => number_format(($t2->net_point + $net_point), 2)
                ]);

                $t1_update = Team::where('id', $t1->id)->update([
                    'played'        => $t1->played + 1,
                    'lose'          => $t1->lose + 1,
                    'net_point'     => number_format(($t1->net_point - $net_point), 2)
                ]);
            }

            return Match::create([
                'team_1_id'         => $data['team_1_id'],
                'team_1'            => $data['team_1'],
                'team_1_point'      => $data['team_1_point'],
                'team_2_id'         => $data['team_2_id'],
                'team_2'            => $data['team_2'],
                'team_2_point'      => $data['team_2_point'],
                'result'            => $result
            ]);
        }
    }

    public function teams()
    {
        return Team::all();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function show(Match $match)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function edit(Match $match)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Match $match)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function destroy(Match $match)
    {
        //
    }

    public function allMatches()
    {
        $match = Match::all();
        return Datatables::of($match)
            ->addColumn('action', function($match){
                return '<a onclick="deleteData('.$match->id.')" class="btn btn-sm btn-danger" style="border-radius: 20%;"><i class="fa fa-ban"></i></a>';
            })->make(true);
    }
}
