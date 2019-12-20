<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;
use App\Player;
use App\Match;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('team.index');
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

    public function players()
    {
        $strong = Player::where('attribute', 'Strong')->where('status', null)->get();
        $weak = Player::where('attribute', 'Average')->where('status', null)->get();
        return response()->json(['strongs' => $strong, 'weaks' => $weak]);
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
            'player_1_id'  => ['required', 'integer'],
            'player_2_id'  => ['required', 'integer'],
        ]);
        if($data)
        {
            $p1 = Player::find($data['player_1_id']);
            $p2 = Player::find($data['player_2_id']);

            $data['team_name'] = $p1->player_name. "_" . $p2->player_name;
            $data['player_1'] = $p1->player_name;
            $data['player_2'] = $p2->player_name;
            $data['played'] = 0;
            $data['win'] = 0;
            $data['lose'] = 0;
            $data['point'] = 0;
            $data['net_point'] = 0;

            $team = Team::create($data);

            if($team)
            {
                Player::where('id', $data['player_1_id'])->update([
                    'status'   => 'Booked'
                ]);
                Player::where('id', $data['player_2_id'])->update([
                    'status'   => 'Booked'
                ]);
            }
            return $team;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function show(Team $team)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Team::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $team = Match::where('team_1_id', $id)->orWhere('team_2_id', $id)->first();
        if($team)
        {
            return "exist";
        }
        Team::destroy($id);
    }

    public function allTeams()
    {
        $team = Team::all();

        return Datatables::of($team)
            ->addColumn('action', function($team){
                return '<a onclick="editData('.$team->id.')" class="btn btn-sm btn-warning" style="border-radius: 20%;"><i class="fa fa-edit"></i></a>'.' '. 
                '<a onclick="deleteData('.$team->id.')" class="btn btn-sm btn-danger" style="border-radius: 20%;"><i class="fa fa-ban"></i></a>';
                
          })->make(true);
    }
}
