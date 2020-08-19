@extends('layouts.app')

@section('content')
<style>
    .green {
        color: green;
    }
    .red {
        color: red;
    }
    a { 
        cursor: pointer;
        color: #fff;
    }
</style>

<header class="special container">
    <span class="icon solid fa-running"></span>
    <h2>Lineup: {{ ($raid->name ?: $raid->raid) . ' ' . $raid->date}}</h2>
    <a href="/raids">&larr; Back</a>
</header>
<section class="wrapper style2 container special-alt">
    Confirmation Mode: <strong>@if ($raid->confirmation) enabled @else disabled @endif</strong>
    <div class="container">
        <table>
            <tr>
                <th width="25%">Tanks</th>
                <th width="25%"></th>
                <th width="25%"></th>
                <th width="25%"></th>
            </tr>
            @foreach ($signups AS $signup)
                @if ($signup->role == 'tank' && $signup->signup == 'yes')
                <tr signup="{{ $signup->id }}">
                        <td>{{ $signup->player }}</td>
                        <td>{{ ucfirst($signup->class) }}</td>
                        
                        @if ($raid->confirmation)
                            <td>
                                @if ($signup->confirmed) <strong class="green">Confirmed</strong> @else <strong class="red">Unconfirmed</strong>@endif</td>
                            </td>
                            <td>
                                @if (!$signup->confirmed)
                                <a onclick="addConfirm({{ $signup->id }});">Confirm</a>
                                @else
                                <a onclick="removeConfirm({{ $signup->id }});">Unconfirm</a>
                                @endif
                            </td>
                        @endif
                    </tr>
                @endif
            @endforeach
        </table>
        <table>
            <tr>
                <th width="25%">Healers</th>
                <th width="25%"></th>
                <th width="25%"></th>
                <th width="25%"></th>
            </tr>
            @foreach ($signups AS $signup)
                @if ($signup->role == 'healer' && $signup->signup == 'yes')
                    <tr signup="{{ $signup->id }}">
                        <td>{{ $signup->player }}</td>
                        <td>{{ ucfirst($signup->class) }}</td>
                        
                        @if ($raid->confirmation)
                            <td>
                                @if ($signup->confirmed) <strong class="green">Confirmed</strong> @else <strong class="red">Unconfirmed</strong>@endif</td>
                            </td>
                            <td>
                                @if (!$signup->confirmed)
                                <a onclick="addConfirm({{ $signup->id }});">Confirm</a>
                                @else
                                <a onclick="removeConfirm({{ $signup->id }});">Unconfirm</a>
                                @endif
                            </td>
                        @endif
                    </tr>
                @endif
            @endforeach
        </table>
        <table>
            <tr>
                <th width="25%">Casters</th>
                <th width="25%"></th>
                <th width="25%"></th>
                <th width="25%"></th>
            </tr>
            @foreach ($signups AS $signup)
                @if ($signup->role == 'caster' && $signup->signup == 'yes')
                    <tr signup="{{ $signup->id }}">
                        <td>{{ $signup->player }}</td>
                        <td>{{ ucfirst($signup->class) }}</td>
                        
                        @if ($raid->confirmation)
                            <td>
                                @if ($signup->confirmed) <strong class="green">Confirmed</strong> @else <strong class="red">Unconfirmed</strong>@endif</td>
                            </td>
                            <td>
                                @if (!$signup->confirmed)
                                <a onclick="addConfirm({{ $signup->id }});">Confirm</a>
                                @else
                                <a onclick="removeConfirm({{ $signup->id }});">Unconfirm</a>
                                @endif
                            </td>
                        @endif
                    </tr>

                @endif
            @endforeach
        </table>
        <table>
            <tr>
                <th width="25%">DPS</th>
                <th width="25%"></th>
                <th width="25%"></th>
                <th width="25%"></th>
            </tr>
            @foreach ($signups AS $signup)
                @if ($signup->role == 'dps' && $signup->signup == 'yes')
                    <tr signup="{{ $signup->id }}">
                        <td>{{ $signup->player }}</td>
                        <td>{{ ucfirst($signup->class) }}</td>
                        
                        @if ($raid->confirmation)
                            <td>
                                @if ($signup->confirmed) <strong class="green">Confirmed</strong> @else <strong class="red">Unconfirmed</strong>@endif</td>
                            </td>
                            <td>
                                @if (!$signup->confirmed)
                                <a onclick="addConfirm({{ $signup->id }});">Confirm</a>
                                @else
                                <a onclick="removeConfirm({{ $signup->id }});">Unconfirm</a>
                                @endif
                            </td>
                        @endif
                    </tr>

                @endif
            @endforeach
        </table>
        <table>
            <tr>
                <th width="25%">Maybe</th>
                <th width="25%"></th>
                <th width="25%"></th>
                <th width="25%"></th>
            </tr>
            @foreach ($signups AS $signup)
                @if ($signup->signup == 'maybe')
                    <tr>
                        <td>{{ $signup->player }}</td>
                        <td>{{ ucfirst($signup->class) }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                @endif
            @endforeach
        </table>
        <table>
            <tr>
                <th width="25%">No</th>
                <th width="25%"></th>
                <th width="25%"></th>
                <th width="25%"></th>
            </tr>
            @foreach ($signups AS $signup)
                @if ($signup->signup == 'no')
                    <tr>
                        <td>{{ $signup->player }}</td>
                        <td>{{ ucfirst($signup->class) }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                @endif
            @endforeach
        </table>
    </div>
</section>

@endsection

@section('scripts')
    <script>
        function addConfirm(signupID) {
            var row = $('[signup=' + signupID + ']');
            $.ajax({
                url: '/raids/{{ $raid->id }}/confirm/' + signupID,
                success: function(data) {
                    row.find('strong').html('Confirmed').removeClass('red').addClass('green');
                    row.find('a').html('Unconfirm').attr('onclick', 'removeConfirm(' + signupID + ')');
                }
            });
        }
        function removeConfirm(signupID) {
            $.ajax({
                url: '/raids/{{ $raid->id }}/unconfirm/' + signupID,
                success: function(data) {
                    row.find('strong').html('Unconfirmed').removeClass('green').addClass('red');
                    row.find('a').html('Confirm').attr('onclick', 'addConfirm(' + signupID + ')');
                }
            })
            var row = $('[signup=' + signupID + ']');
        }
    </script>
@endsection