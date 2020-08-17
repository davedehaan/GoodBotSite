@extends('layouts.app')

@section('content')
<style>
    label {
        display: block;
        width: 100%
        clear: both;
        margin: 10px 0;
        border-bottom: solid 1px #CCC;
        color: #333;
        font-weight: bold;
    }
    select, input {
        width: 50%;
        height: 30px;
    }
    button {
        margin: 30px 0 10px;
    }
</style>

<header class="special container">
    <span class="icon solid fa-running"></span>
    <h2>Options: {{ $server->name }}</h2>
</header>
<section class="wrapper style2 container special-alt">
    <div class="container">
        <form method="POST" action="/dashboard/options/{{ $server->id }}">
            <div class="gb-row">
                <label for="faction">Faction</label>
                <select name="faction">
                    <option></option>
                    <option @if ($settings->faction == 'Alliance') selected @endif>Alliance</option>
                    <option @if ($settings->faction == 'Horde') selected @endif>Horde</option>
                    <option @if ($settings->faction == 'Both') selected @endif>Both</option>
                </select>
            </div>
            <div class="gb-row">
                <label for="region">Region</label>
                <select name="region">
                    <option></option>
                    <option @if ($settings->region == 'NA') selected @endif>NA</option>
                    <option @if ($settings->region == 'EU') selected @endif>EU</option>
                </select>
            </div>
            <div class="gb-row">
                <label for="wowServer">Server</label>
                <select name="wowServer">
                    <option></option>
                    <optgroup label="North America/Oceanic">
                        @foreach ($naServerList AS $wowServer)
                            <option @if ($settings->server == $wowServer) selected @endif>{{ $wowServer}}</option>
                        @endforeach
                    </optgroup>
                    <optgroup label="Europe">
                        @foreach ($euServerList AS $wowServer)
                            <option @if ($settings->server == $wowServer) selected @endif>{{ $wowServer}}</option>
                        @endforeach
                    </optgroup>
                </select>
            </div>
            <div class="gb-row">
                <label for="sheetID">Google Spreadsheet ID</label>
                <input name="sheetID" value="{{ $settings->sheet }}" />
            </div>
            @csrf
            <div class="gb-row">
                <button>Save</button>
            </div>
        </form>    
    </div>
</section>

@endsection

@section('scripts')

@endsection