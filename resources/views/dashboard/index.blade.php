@extends('layouts.app')

@section('content')
<header class="special container">
    <span class="icon solid fa-running"></span>
    <h2>Dashboard</h2>
</header>
<section class="wrapper style2 container special-alt">
    <div class="container">
        <div class="row aln-center">
            <h3>Please select a server you <br />have administrative rights on</h3>
            <select class="large-select" onchange="window.location='/dashboard/' + this.value">
            <option>-</option>
            @foreach ($servers AS $server)
                @if ($server->permissions == 2147483647)
                <option value="{{ $server->id }}">{{ $server->name }}</option>
                @endif
            @endforeach
            </select>
        </div>
    </div>
</section>

@endsection

@section('scripts')

@endsection