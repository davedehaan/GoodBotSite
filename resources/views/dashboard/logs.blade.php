@extends('layouts.app')

@section('content')
<header class="special container">
    <span class="icon solid fa-running"></span>
    <h2>Logs: {{ $server->name }}</h2>
</header>
<section class="wrapper style2 container special-alt">
    <div class="container">
        <div class="gb-row">
            <table>
                <tr>
                    <th width="50%">Event</th>
                    <th>User</th>
                    <th>Channel</th>
                    <th>Time/Date</th>
                </tr>
                @foreach ($logs AS $log)
                    <tr>
                        <td>{{ $log->event[0] }}</td>
                        <td>{{ $log->event[1] }}</td>
                        <td>{{ $log->event[2] }}</td>
                        <td>{{ $log->createdAt }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
        <div class="gb-row">
            @if ($page > 1) 
                <a href="/dashboard/logs/{{ $server->id }}?p={{ $page - 1 }}">&larr; Previous</a> &nbsp;&nbsp;|&nbsp;&nbsp;
            @endif
            <a href="/dashboard/logs/{{ $server->id }}?p={{ $page + 1 }}">Next &rarr;</a>
        </div>
    </div>
</section>

@endsection

@section('scripts')

@endsection