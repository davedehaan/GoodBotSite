@extends('layouts.app')

@section('content')
<img src="https://cdn.discordapp.com/icons/{{ $server->id }}/{{ $server->icon }}.png" />
<h2>Your characters on {{ $server->name }}</h2>
<div class="container">
    <div class="row justify-content-center">
        <table>
            <tr>
                <th>Character</th>
                <th>Class</th>
                <th>Role</th>
            </tr>
        @foreach ($characters AS $character) 
            <tr>
                <td>{{ $character->name }}</td>
                <td>{{ $character->class }}</td>
                <td>{{ $character->role }}</td>
            </tr>
        @endforeach
        </table>
    </div>
</div>
@endsection