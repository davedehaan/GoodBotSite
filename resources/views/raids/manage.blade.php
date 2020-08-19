@extends('layouts.dashboard')

@section('content')

<section class="wrapper style2 container special-alt">
    <div class="container">
        <a href="/raids/{{ $raid->id }}/command/pingall">
            <button>Ping Raid</button>
        </a>
        <a href="/raids/{{ $raid->id }}/command/pingconfirmed">
            <button>Ping Confirmed</button>
        </a>
        <a href="/raids/{{ $raid->id }}/command/pingnoreserve">
            <button>Ping No Reserve</button>
        </a>
        <a href="/raids/{{ $raid->id }}/command/pingunsigned">
            <button>Ping Unsigned</button>
        </a>
        <form method="POST" action="/raids/{{ $raid->id }}/manage">
            <div class="gb-row">
                <label for="title">Title</label>
                <input name="title" value="{{ $raid->title ?: $raid->name ?: $raid->raid }}"/>
            </div>
            <div class="gb-row">
                <label for="raid">Raid</label>
                <select name="raid">
                    @foreach ($raids AS $expansion => $expacRaids) 
                        <optgroup label="{{ $expansion }}">
                        @foreach ($expacRaids AS $key => $raidName)
                        <option value="{{ $key }}"
                            @if ($key == strtolower($raid->raid)) 
                                selected
                            @endif
                        >{{ $raidName }}</option>
                        @endforeach
                    @endforeach
                    </optgroup>
                </select>
            </div>
            <div class="gb-row">
                <label for="date">Date</label>
                <input name="date" value="{{ $raid->description }}" />
            </div>
            <div class="gb-row">
                <label for="description">Description</label>
                <textarea name="description" />{{ $raid->description }}</textarea>
            </div>
            <div class="gb-row">
                <label for="region">Channel Name</label>
                <input name="channel" value="{{ $channel->name }}"/>
            </div>
            <div class="gb-row">
                <label for="confirmation">Confirmation Mode</label>
                <select name="confirmation">
                    <option value="0">no</option>
                    <option value="1"
                    @if ($raid->confirmation) selected @endif
                    >yes</option>
                </select>
            </div>
            <div class="gb-row">
                <label for="softreserve">Soft Reserves</label>
                <select name="softReserve">
                    <option value="0">no</option>
                    <option value="1"
                    @if ($raid->confirmation) selected @endif
                    >yes</option>
                </select>
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