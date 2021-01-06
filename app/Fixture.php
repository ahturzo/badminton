<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fixture extends Model
{
    protected $fillable = ['match_no', 'team1', 'team2']; 
}
