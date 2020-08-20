@extends('layouts.app')

@section('content')
<header class="special container">
    <span class="icon solid fa-running"></span>
    <h2>Raids</h2>
</header>
<section class="wrapper style2 container special-alt">
    <!-- <a href="/raids/new">    
        <button>Create Raid</button>
    </a> -->
    <div class="container">
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
                <td><a href="/raids/{{ $raid->id }}/lineup">Lineup</a></td>
                <td><a href="/raids/{{ $raid->id }}/reserves">Reserves</a></td>
                <td><a href="/raids/{{ $raid->id }}/manage">Manage</a></td>
            @endforeach
            </tr>
        </table>
    </div>
</section>

@endsection

@section('scripts')

@endsection