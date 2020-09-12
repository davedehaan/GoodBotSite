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

        <br />
        <a href="/raids/crosspost/{{ $raid->id }}">
            <button>Cross Post</button>
        </a>   
        <a href="/raids/{{ $raid->id }}/command/dupe">
            <button>Dupe</button>
        </a>   
        <a href="/raids/{{ $raid->id }}/command/archive">
            <button>Archive</button>
        </a>   
        @include('raids/_partials/form')
    </div>
</section>

@endsection
