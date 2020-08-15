@extends('layouts.app')

@section('content')
<style>
    .fa-save {
        display: none;
    }
</style>
<header class="special container">
    <img style="border-radius: 64px;" src="https://cdn.discordapp.com/icons/{{ $server->id }}/{{ $server->icon }}.png" />
    <h2>Character List<br /> {{ $server->name }} </h2>
</header>
<section class="wrapper style2 container special-alt">
    <div class="container">
        <div class="row justify-content-center">
            <table>
                <tr>
                    <th width="30%">Character</th>
                    <th width="30%">Class</th>
                    <th width="30%">Role</th>
                    <th></th>
                </tr>
            @foreach ($characters AS $character) 
                <tr character="{{ $character->id }}">
                    <td>
                        <label class="character-name">{{ $character->name }}</label>
                        <input class="input-name" value="{{ $character->name }}" />
                    </td>
                    <td>
                        <label class="character-class">{{ $character->class }}</label>
                        <select class="select-class">
                            @foreach ($classes AS $class)
                                <option 
                                @if ($character->class == $class)
                                    selected
                                @endif
                                value="{{ $class }}">{{ $class }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <label class="character-role">{{ $character->role }}</label>
                        <select class="select-role">
                            @foreach ($roles AS $role)
                                <option 
                                @if ($character->role == $role)
                                    selected
                                @endif
                                value="{{ $role }}">{{ $role }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <a onclick="saveCharacter({{ $character->id }});">
                            <i class="fa fa-save"></i>
                        </a>
                        <a onclick="showSelect({{ $character->id }});">
                            <i class="fa fa-pencil"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            <tr character="0">
                <td>
                    <input class="input-name" value="" />
                </td>
                <td>
                    <select class="select-class">
                        @foreach ($classes AS $class)
                            <option value="{{ $class }}">{{ $class }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select class="select-role">
                        @foreach ($roles AS $role)
                            <option value="{{ $role }}">{{ $role }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <a onclick="saveCharacter(0);">
                        <i class="fa fa-save"></i>
                    </a>
                    <a onclick="addNew();"><i class="fa fa-plus"></i></a>
                </td>   
            </tr>
            </table>
        </div>
    </div>
</section>
<script>
    function addNew() {
        var row = $('[character=0]');
        row.find('i.fa-plus').hide();
        row.find('i.fa-save').show();
        row.find('select, input').show();
    }

    function showSelect(characterID) {
        var row = $('[character=' + characterID + ']');
        if (row.find('i.fa-pencil').length) {
            row.find('i.fa-pencil').removeClass('fa-pencil').addClass('fa-ban');
            row.find('i.fa-save').show();
            row.find('label').hide();
            row.find('select, input').show();
        } else {
            resetRow(row);
        }
    }
    function saveCharacter(characterID) {
        var row = $('[character=' + characterID + ']');
        var nameInput = row.find('.input-name');
        if (!nameInput.val().length) {
            nameInput.css('background', '#b00b00');
            return false;
        }
        nameInput.css('background', '');

        var serverID = "{{ $server->id }}";
        var saveUrl = '/characters/save/' + serverID + '/' + characterID;
        saveUrl += '?name=' + row.find('.input-name').val();
        saveUrl += '&class=' + row.find('.select-class').val();
        saveUrl += '&role=' + row.find('.select-role').val();
        window.location = saveUrl;
        resetRow(row)
    }
    function resetRow(row) {
        row.find('i.fa-ban').removeClass('fa-ban').addClass('fa-pencil');
        row.find('i.fa-save').hide();
        row.find('label').show();
        row.find('select, input').hide();
    }
</script>
@endsection
