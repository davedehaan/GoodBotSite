@extends('layouts.app')

@section('content')
<header class="special container">
    <span class="icon solid fa-running"></span>
    <h2>{{ $server->name }}</h2>
</header>
<section class="wrapper style2 container special-alt">
    <div class="container">
        <div class="gb-row aln-center">
            <a href="/dashboard/options/{{ $server->id }}">Options &rarr;</a><br />
            <a href="/dashboard/logs/{{ $server->id }}">View my logs &rarr;</a>
        </div>
    </div>
</section>

@endsection

@section('scripts')

@endsection