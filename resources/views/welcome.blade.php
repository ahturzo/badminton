@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="table-responsive">
            <h1>Points Table</h1>
            <table class="table table-hover">
                <thead>
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
                        <tr class="table-primary">
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
    </div>
    <br>
    <div class="container">
        <div class="table-responsive">
            <h1>All Matches</h1>
            <table class="table table-hover">
                <thead>
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
                        <tr class="table-primary">
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
    </div>
@endsection