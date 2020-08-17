@extends('layouts.dashboard')

@section('content')

<section class="wrapper style2 container special-alt">
    <div class="container">
        <form method="POST" action="/dashboard/settings/{{ $server->id }}">
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