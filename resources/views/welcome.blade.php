<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Badminton</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }
            .full-height {
                height: 50vh;
            }
            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }
            .position-ref {
                position: relative;
            }
            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }
            .content {
                text-align: center;
            }
            .title {
                font-size: 50px;
            }
            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }
            .m-b-md {
                margin-bottom: 30px;
            }
            table{
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}"><i class="fas fa-home"></i> Home</a>
                    @else
                        <a href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> Login</a>
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Badminton Tournament - {{ \Carbon\Carbon::now()->format('Y') }}
                    <hr>
                </div>
            </div>
        </div>

        <div class="container">
            @if(count($point) > 0)
                <div class="table-responsive">
                    <h1 class="text-center">Points Table</h1>
                    <table class="table table-hover table-bordered table-striped">
                        <thead class="bg-dark text-white">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Team</th>
                                <th scope="col">Player 1</th>
                                <th scope="col">Player 2</th>
                                <th scope="col">Played</th>
                                <th scope="col">Win</th>
                                <th scope="col">Lost</th>
                                <th scope="col">Point</th>
                                <th scope="col">Net Point</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i =0; @endphp
                            @foreach($point as $team)
                                @if($i >= 0 && $i <= 7)
                                <tr class="text-white" style="background-color: #008000;">
                                @else
                                <tr>
                                @endif
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $team->team_name }}</td>
                                    <td>{{ $team->player_1 }}</td>
                                    <td>{{ $team->player_2 }}</td>
                                    <td>{{ $team->played }}</td>
                                    <td>{{ $team->win }}</td>
                                    <td>{{ $team->lose }}</td>
                                    <td>{{ $team->point }}</td>
                                    <td>{{ $team->net_point }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <br>
            @if(sizeof($fixtures))
                <h1 class="text-center">Fixture</h1><hr>
                <div class="row">
                    @php $size = sizeof($fixtures); $j=$k=1; @endphp
                    <div class="col-12 col-md-4"> 
                        <div class="table-responsive">
                            <h4 class="text-center">Match Day {{ $j++ }}</h4>  
                            <table class="table table-hover table-bordered">
                                <thead class="text-white bg-dark">
                                    <tr>
                                        <th scope="col">Match</th>
                                        <th scope="col">Team 1</th>
                                        <th scope="col">Team 2</th>
                                    </tr>
                                </thead>
                                <tbody>
                    @for($i=0; $i<$size; $i++)
                        @if((($i+1)%9) == 0)
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-12 col-md-4"> 
                                <div class="table-responsive">
                                    <h4 class="text-center">Match Day {{ $j++ }}</h4>
                                    <table class="table table-hover table-bordered">
                                        <thead class="text-white bg-dark">
                                            <tr>
                                                <th scope="col">Match</th>
                                                <th scope="col">Team 1</th>
                                                <th scope="col">Team 2</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $flag = 0; @endphp
                                            @foreach($matches as $match)
                                                @if(($match->team_1 == $fixtures[$i]->team1 && $match->team_2 == $fixtures[$i]->team2) || ($match->team_1 == $fixtures[$i]->team2 && $match->team_2 == $fixtures[$i]->team1))
                                                    @php $flag = 1; @endphp
                                                @endif
                                            @endforeach
                                            <tr @if($flag == 1) style="background-color: #800000;" class="text-white" @endif>
                                                <td>{{ $k++ }}</td>
                                                <td>{{ $fixtures[$i]->team1 }}</td>
                                                <td>{{ $fixtures[$i]->team2 }}</td>
                                            </tr>
                        @else
                            @php $flag = 0; @endphp
                            @foreach($matches as $match)
                                @if(($match->team_1 == $fixtures[$i]->team1 && $match->team_2 == $fixtures[$i]->team2) || ($match->team_1 == $fixtures[$i]->team2 && $match->team_2 == $fixtures[$i]->team1))
                                    @php $flag = 1; @endphp
                                @endif
                            @endforeach
                            <tr @if($flag == 1) style="background-color: #800000;" class="text-white" @endif>
                                <td>{{ $k++ }}</td>
                                <td>{{ $fixtures[$i]->team1 }}</td>
                                <td>{{ $fixtures[$i]->team2 }}</td>
                            </tr>
                        @endif
                    @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
            <br>

            @if(count($matches) > 0)
                <div class="table-responsive">
                    <h1>All Matches</h1>
                    <table class="table table-hover table-bordered table-striped m-b-md">
                        <thead class="text-white bg-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Team 1</th>
                                <th scope="col">Team 1 Point</th>
                                <th scope="col">Team 2 Point</th>
                                <th scope="col">Team 2</th>
                                <th scope="col">Result</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $j =0; @endphp
                            @foreach($matches as $match)
                                <tr class="text-white" style="background-color: #191970;">
                                    <td>{{ ++$j }}</td>
                                    <td>{{ $match->team_1 }}</td>
                                    <td>{{ $match->team_1_point }}</td>
                                    <td>{{ $match->team_2_point }}</td>
                                    <td>{{ $match->team_2 }}</td>
                                    <td>{{ $match->result }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </body>
</html>