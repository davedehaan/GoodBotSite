@extends('layouts.app')

@section('content')
<h2>Please Select a Server</h2>
<div class="container">
    <div class="row justify-content-center">
        <select onchange="window.location='/characters/' + this.value">
            <option>-</option>
            @foreach ($servers AS $server)
                <option value="{{ $server->id }}">{{ $server->name}}</option>
            @endforeach
        </select>
    </div>
</div>
@endsection