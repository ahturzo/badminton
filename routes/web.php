<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'PublicController@pointTable');

Auth::routes([
  'register' => false, // Registration Routes...
  'reset' => false, // Password Reset Routes...
  'verify' => false, // Email Verification Routes...
]));

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth'])->group(function()
{
	Route::resource('player', 'PlayerController');
	Route::get('allPlayer', 'PlayerController@allPlayers')->name('all.player');

	Route::resource('team', 'TeamController');
	Route::get('allTeam', 'TeamController@allTeams')->name('all.team');
	Route::get('getPlayers', 'TeamController@players')->name('get.players');

	Route::resource('match', 'MatchController');
	Route::get('allMatch', 'MatchController@allMatches')->name('all.match');
	Route::get('getTeams', 'MatchController@teams')->name('get.teams');
});
