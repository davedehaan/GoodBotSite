@extends('layouts.app')

@section('content')
<script>const whTooltips = {colorLinks: true, iconizeLinks: true, renameLinks: true};</script>
<script src="https://wow.zamimg.com/widgets/power.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
    .reserve-select {
        display: none;
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
            <th style="wdith: 200px;">Name</th>
            <th style="width: 400px;">Reserve</th>
            <th>
        </tr>
        @foreach ($signups AS $signup) 
            @if ($signup->signup == 'yes')
                <tr>
                    <td>{{ $signup->player }}</td>
                    <td>
                        @if ($signup->reserve)
                            <a href="#" id="reserve-link-{{ $signup->id }}" data-wowhead="item={{ $signup->reserve->item->itemID }}">{{ $signup->reserve->item->name }}</a>
                        @else
                            none
                        @endif
                        <select class="reserve-select" id="reserve-select-{{ $signup->id }}" onchange="saveReserve(this.value, {{ $signup->id }});">
                            <option value="0">None</option>
                            @foreach ($items AS $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <a onclick="showSelect({{ $signup->id }});">
                            <i class="fa fa-pencil"></i>
                        </a>
                    </td>
                </tr>
            @endif
        @endforeach
        </table>
        <br /><br />
    </div>
</div>
<script>
    function saveReserve(itemID, signupID) {
        window.location = '/reserve/' + signupID + '/' + itemID;
    }
    function showSelect(signupID) {
        $('#reserve-select-' + signupID).show();
        $('#reserve-link-' + signupID).hide();
    }
</script>
@endsection