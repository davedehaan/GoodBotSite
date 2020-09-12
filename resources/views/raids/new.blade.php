@extends('layouts.dashboard')

@section('content')

<section class="wrapper style2 container special-alt">
    <div class="container">
        @if ($server)
            @include('raids/_partials/form')
        @else
        <div class="row aln-center">
            <h3>Please select the server you'd <br />like to create a raid on</h3>
            <select class="large-select" onchange="window.location='/raids/new/' + this.value">
            <option>-</option>
            @foreach ($guilds AS $guild)
                @if ($guild->permissions == 2147483647)
                <option value="{{ $guild->id }}">{{ $guild->name }}</option>
                @endif
            @endforeach
            </select>
        </div>
        @endif
    </div>
</section>

@endsection
