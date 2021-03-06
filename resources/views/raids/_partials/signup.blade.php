<table>
    <tr>
        <th width="30%" colspan="2">{{ $label }}</th>
        <th width="25%"></th>
        <th width="25%"></th>
        <th width="20%"></th>
    </tr>
    
    @foreach ($signups AS $key => $signup)
        @if ($signup->role == $role && $signup->signup == 'yes')
        <tr signup="{{ $signup->id }}">
            <td width="30px">{{ $signup->order }}</td>
            <td onclick="playerInfo(this, {{ $signup->character->mainID ?: $signup->character->id }});">{{ $signup->player }} 
            @if ($signup->character->mainID)
                (<i class="orange">alt</i>)
            @else
                (<i class="green">main</i>)
            @endif
            </td>
            <td class="color-{{ $signup->class }}">{{ ucfirst($signup->class) }}</td>
            <td>
                @if ($raid->confirmation)
                    @if ($signup->confirmed) <strong class="green">Confirmed</strong> @else <strong class="red">Unconfirmed</strong>@endif</td>
                @endif
            </td>
            <td class="text-right">
                @if ($raid->confirmation)
                    <a class="green" onclick="addConfirm({{ $signup->id }});"><span class="icon solid fa-thumbs-up"></span></a>
                    <a class="red" onclick="removeConfirm({{ $signup->id }});"><span class="icon solid fa-thumbs-down"></span></a>
                @endif
                <a onclick="gearCheck('{{ $signup->player }}');"><span class="icon solid fa-search"></span></a>
            </td>
        </tr>
        @endif
    @endforeach
</table>