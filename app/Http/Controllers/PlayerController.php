<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Player;
use App\Team;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('player.index');
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
            'player_name'  => ['required', 'string'],
            'attribute'    => ['required', 'string']
        ]);
        if($data)
        {
            return Player::create($data);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function show(Player $player)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Player::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $data = $request->validate([
            'player_name'  => ['required', 'string'],
            'attribute'    => ['required', 'string'],
        ]);
        if($data)
        {
            return Player::where('id', $id)->update($data);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $player = Team::where('player_1_id', $id)->orWhere('player_2_id', $id)->first();
        if($player)
        {
            return "exist";
        }
        Player::destroy($id);
    }

    public function allPlayers()
    {
        $player = Player::all();

        return Datatables::of($player)
          ->addColumn('action', function($player){
                return '<a onclick="editData('.$player->id.')" class="btn btn-sm btn-warning" style="border-radius: 20%;"><i class="fa fa-edit"></i></a>'.' '. 
                '<a onclick="deleteData('.$player->id.')" class="btn btn-sm btn-danger" style="border-radius: 20%;"><i class="fa fa-ban"></i></a>';
                
          })->make(true);
    }
}
