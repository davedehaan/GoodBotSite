@extends('layouts.app')

@section('content')
<style>
    th, td {
        text-align: left;
        padding: 5px 10px;
        border-bottom: dotted 1px #CCC;
    }
    td a {
        padding: 0;
    }
</style>
<h2>Raid Signups: {{ $raidName }}</h2>
<div class="container">
    <div class="row justify-content-center">
        <table>
        <tr>
            <th>Date</th>
            <th>Name</th>
            <th>Raid Type</th>
            <th colspan=2>Links</th>
        </tr>
        @foreach ($raids AS $raid) 
        <tr>
            <td>{{ $raid->date }}</td>
            <td>{{ $raid->name ? $raid->name : $raid->raid}}</td>
            <td>{{ $raid->raid }}</td>
            <td><a href="/signups/{{ $raid->id }}">Signups &rarr;</a></td>
            <td>
                <a target="_blank" href="https://discord.com/channels/{{ $raid->guildID }}/{{ $raid->channelID }}">Discord &rarr;</a>
            </td>
        </tr>
        @endforeach
        </table>
        <br /><br />
    </div>
</div>
@endsection