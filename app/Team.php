<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['team_name', 'player_1_id', 'player_1', 'player_2_id', 'player_2', 'played', 'win', 'lose', 'point', 'net_point'];
}
