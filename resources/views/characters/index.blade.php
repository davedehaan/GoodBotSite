@extends('layouts.app')

@section('content')
<header class="special container">
    <span class="icon solid fa-address-book"></span>
    <h2>Character List<br /> Server Selection </h2>
</header>
<section class="wrapper style2 container special-alt">
    <div class="container">
        <strong>Server Selection</strong><br />
        <select onchange="window.location='/characters/' + this.value">
            <option>-</option>
            @foreach ($servers AS $server)
                <option value="{{ $server->id }}">{{ $server->name}}</option>
            @endforeach
        </select>
    </div>
</section>
@endsection