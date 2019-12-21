<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    protected $fillable = ['team_1_id', 'team_1', 'team_1_point', 'team_2_id', 'team_2', 'team_2_point', 'result'];
}
