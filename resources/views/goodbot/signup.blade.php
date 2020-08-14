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
    .justify-content-left {
        text-align: left;
    }

    .justify-content-center {
        text-align: center;
    }

    table {
        width: 100%;
        border-left: dotted 1px #CCC;
        border-right: dotted 1px #CCC;
    }
</style>
<h2>Raid Signups: {{ $raid->name ? $raid->name : $raid->raid}}</h2>
<a href="/{{ $hash->hash }}">&larr; Back</a>
<div class="container">
    <div class="row justify-content-left">
        <strong>Date: </strong> {{ $raid->date }}<br />
        <strong>Raid: </strong> {{ $raid->raid }}<br />
        <br />
        <br />
    </div>
    <div class="row justify-content-center">
        <table>
        <tr>
            <th>Name</th>
            <th>Signup</th>
        </tr>
        @foreach ($signups AS $signup) 
        <tr>
            <td>{{ $signup->player }}</td>
            <td>{{ $signup->signup }}</td>
        </tr>
        @endforeach
        </table>
        <br /><br />
    </div>
</div>
@endsection