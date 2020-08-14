@extends('layouts.app')

@section('content')
<script>const whTooltips = {colorLinks: true, iconizeLinks: true, renameLinks: true};</script>
<script src="https://wow.zamimg.com/widgets/power.js"></script>
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
            <th>Reserve</th>
        </tr>
        @foreach ($signups AS $signup) 
            @if ($signup->signup == 'yes')
                <tr>
                    <td>{{ $signup->player }}</td>
                    <td>
                        @if ($signup->reserve)
                            <a href="#" data-wowhead="item={{ $signup->reserve->item->itemID }}">{{ $signup->reserve->item->name }}</a>
                        @else
                            none
                        @endif
                    </td>
                </tr>
            @endif
        @endforeach
        </table>
        <br /><br />
    </div>
</div>
@endsection