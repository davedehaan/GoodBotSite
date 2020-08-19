@extends('layouts.app')

@section('content')
<header class="special container">
    <span class="icon solid fa-running"></span>
    <h2>Lineup: {{ ($raid->name ?: $raid->raid) . ' ' . $raid->date}}</h2>
    <a href="/raids">&larr; Back</a>
</header>
<section class="wrapper style2 container special-alt">
    <div class="container">
        <table>
            <tr>
                <th width="50%">Tanks</th>
                <th width="25%"></th>
                <th></th>
            </tr>
            @foreach ($signups AS $signup)
                @if ($signup->role == 'tank' && $signup->signup == 'yes')
                    <tr>
                        <td>{{ $signup->player }}</td>
                        <td>{{ ucfirst($signup->class) }}</td>
                        <td>{{ date('F d', strtotime($signup->createdAt)) . ' @ ' . date('H:i:s', strtotime($signup->createdAt)) }}</td>
                        @if ($raid->confirm)
                            <td>
                                <a onclick="confirm({{ $signup->id }});">Confirm</a>
                            </td>
                        @endif
                    </tr>
                @endif
            @endforeach
        </table>
        <table>
            <tr>
                <th width="50%">Healers</th>
                <th width="25%"></th>
                <th></th>
            </tr>
            @foreach ($signups AS $signup)
                @if ($signup->role == 'healer' && $signup->signup == 'yes')
                    <tr>
                        <td>{{ $signup->player }}</td>
                        <td>{{ ucfirst($signup->class) }}</td>
                        <td>{{ date('F d', strtotime($signup->createdAt)) . ' @ ' . date('H:i:s', strtotime($signup->createdAt)) }}</td>
                        @if ($raid->confirm)
                            <td>
                                <a onclick="confirm({{ $signup->id }});">Confirm</a>
                            </td>
                        @endif
                    </tr>
                @endif
            @endforeach
        </table>
        <table>
            <tr>
                <th width="50%">Casters</th>
                <th width="25%"></th>
                <th></th>
            </tr>
            @foreach ($signups AS $signup)
                @if ($signup->role == 'caster' && $signup->signup == 'yes')
                    <tr>
                        <td>{{ $signup->player }}</td>
                        <td>{{ ucfirst($signup->class) }}</td>
                        <td>{{ date('F d', strtotime($signup->createdAt)) . ' @ ' . date('H:i:s', strtotime($signup->createdAt)) }}</td>
                        @if ($raid->confirm)
                            <td>
                                <a onclick="confirm({{ $signup->id }});">Confirm</a>
                            </td>
                        @endif
                    </tr>
                @endif
            @endforeach
        </table>
        <table>
            <tr>
                <th width="50%">DPS</th>
                <th width="25%"></th>
                <th></th>
            </tr>
            @foreach ($signups AS $signup)
                @if ($signup->role == 'dps' && $signup->signup == 'yes')
                    <tr>
                        <td>{{ $signup->player }}</td>
                        <td>{{ ucfirst($signup->class) }}</td>
                        <td>{{ date('F d', strtotime($signup->createdAt)) . ' @ ' . date('H:i:s', strtotime($signup->createdAt)) }}</td>

                    </tr>
                @endif
            @endforeach
        </table>
        <table>
            <tr>
                <th width="50%">Maybe</th>
                <th width="25%"></th>
                <th></th>
            </tr>
            @foreach ($signups AS $signup)
                @if ($signup->signup == 'maybe')
                    <tr>
                        <td>{{ $signup->player }}</td>
                        <td>{{ ucfirst($signup->class) }}</td>
                        <td>{{ date('F d', strtotime($signup->createdAt)) . ' @ ' . date('H:i:s', strtotime($signup->createdAt)) }}</td>

                    </tr>
                @endif
            @endforeach
        </table>
        <table>
            <tr>
                <th width="50%">No</th>
                <th width="25%"></th>
                <th></th>
            </tr>
            @foreach ($signups AS $signup)
                @if ($signup->signup == 'no')
                    <tr>
                        <td>{{ $signup->player }}</td>
                        <td>{{ ucfirst($signup->class) }}</td>
                        <td>{{ date('F d', strtotime($signup->createdAt)) . ' @ ' . date('H:i:s', strtotime($signup->createdAt)) }}</td>

                    </tr>
                @endif
            @endforeach
        </table>
    </div>
</section>

@endsection

@section('scripts')

@endsection