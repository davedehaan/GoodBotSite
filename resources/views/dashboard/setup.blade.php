@extends('layouts.dashboard')

@section('content')
<style>
    .container {
        display: none;
    }
</style>
<section class="wrapper style2 special-alt">
    <div class="container" step="1">
        <div class="gb-row">
            <label for="raidCategory">What faction do you play as?</label>
            <select id="raidCategory" name="raidCategory">
                <option></option>
                <option>Alliance</option>
                <option>Horde</option>
                <option>Both</option>
            </select>
        </div>
        <button onclick="goTo(2);">Next</button>
    </div>

    <div class="container" step="2">
        <div class="gb-row">
            <label for="raidCategory">Which category should GoodBot create your raids under?</label>
            <select id="raidCategory" name="raidCategory">
                <option>
                @foreach ($channels AS $channel)
                    @if ($channel->type == 4)
                        <option value="{{ $channel->id }}">{{ $channel->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <button onclick="goTo(1);">Back</button>
        <button onclick="goTo(3);">Next</button>
    </div>
    <div class="container" step="3">
        <div class="gb-row">
            <label for="setup">Would you like channels set up for setting name, class and role?</label>
            <select id="setup" name="setup">
                <option></option>
                <option>Yes</option>
                <option>No</option>               
            </select>
        </div>
        <button onclick="goTo(2);">Back</button>
        <button onclick="goTo(4);">Next</button>
    </div>
    <div class="container" step="4">
        <div class="gb-row">
            <label for="wowServer">What server are you on?</label>
                <select id="wowServer" name="wowServer">
                    <option></option>
                    <optgroup label="North America/Oceanic">
                        @foreach ($naServerList AS $wowServer)
                            <option value="NA/{{ $wowServer}}">{{ $wowServer }}</option>
                        @endforeach
                    </optgroup>
                    <optgroup label="Europe">
                        @foreach ($euServerList AS $wowServer)
                            <option value="EU/{{ $wowServer}}">{{ $wowServer }}</option>
                        @endforeach
                    </optgroup>
                </select>        </div>
        <button onclick="goTo(3);">Back</button>
        <button onclick="finish();">Finish</button>
    </div>
</section>
@endsection

@section('scripts')
<script>
    $(window).ready(() => {
        goTo(1);
    });
    function goTo(id) {
        $('.container').hide();
        $("[step=" + id + "]").show();
    }

    function finish() {
        var wowServer = $('#wowServer').val();
        var setup = $('#setup').val();
        var raidCategory = $('#raidCategory').val();
        window.location = '/dashboard/setup/save/{{ $server->id }}?server=' + wowServer + '&setup=' + setup + '&raidCategory=' + raidCategory;
    }
    </script>
@endsection