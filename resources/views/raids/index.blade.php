@extends('layouts.dashboard')

@section('content')
<section class="wrapper style2 container special-alt">
    <div class="container">
        <h2>Manage Raids</h2>
        <table>
            <tr>
                <th>Discord</th>
                <th>Name</th>
                <th>Type</th>
                <th>Date</th>
                <th width="7%"></th>
                <th width="7%"></th>
                <th width="7%"></th>
            </tr>
            @foreach ($raids AS $raid)
            <tr>
                <td>{{ $guilds[$raid->guildID]->name }}
                <td>{{ $raid->title ?: $raid->name ?: $raid->raid }}</td>
                <td>{{ $raid->raid }}</td>
                <td>{{ $raid->date }}</td>
                <td><a href="/raids/lineup/{{ $raid->id }}">Lineup</a></td>
                <td><a href="/raids/reserves/{{ $raid->id }}">Reserves</a></td>
                <td><a href="/raids/manage/{{ $raid->id }}">Manage</a></td>
            @endforeach
            </tr>
        </table>
        <a href="/raids/new">
            <button>Create Raid</button>
        </a>
    </div>
</section>

@endsection

@section('scripts')

@endsection