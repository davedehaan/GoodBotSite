@extends('layouts.dashboard')

@section('content')

<style>
table.logs td:last-of-type {
    text-align: left;
}
.aln-right {
    text-align: right;
}
</style>

<section class="wrapper style2 container special-alt">
    <div class="container">
        <div class="gb-row">
            <table class="logs">
                <tr>
                    <th width="50%">Event</th>
                    <th>User</th>
                    <th>Channel</th>
                    <th width="15%">Time/Date</th>
                </tr>
                @foreach ($logs AS $log)
                    <tr>
                        <td>{{ $log->event[0] }}</td>
                        <td>{{ str_replace('Member: ', '', $log->event[1]) }}</td>
                        <td>{{ str_replace('Channel: ', '', $log->event[2]) }}</td>
                        <td>{{ $log->createdAt }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
        <div class="gb-row aln-right">
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