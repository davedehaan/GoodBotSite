@extends('layouts.dashboard')

@section('content')
<style>
    .fa-save {
        display: none;
    }
    .fa span  {
      font-family: Lato, sans-serif;
      font-weight: bold;
    }
</style>
<section class="wrapper style2 container special-alt">
    @if (empty($characters))
    <div class="container">
        <h2>You don't have a character set up on this server yet, {{ $nick }}!</h2>
        <h4>Let's fix that!</h4>
        <div class="gb-row">
            <label>What is your main's name?</label>
            <input name="name" value="{{ $nick }}" />
        </div>  
        <div class="gb-row">
            <label>What class is your main?</label>
            <select name="class">
                <option></option>
                @foreach ($classes AS $class)
                    <option value="{{ $class }}">{{ $class }}</option>
                @endforeach
            </select>
        </div>  
        <div class="gb-row">
            <label>What role is your main?</label>
            <select name="role">
                <option></option>
                @foreach ($roles AS $role)
                    <option value="{{ $role }}">{{ $role }}</option>
                @endforeach
            </select>
        </div>  
        <button onclick="addCharacter();">Add Character</button>
    </div>
    @else
    <div class="container">
        <div class="row justify-content-center">
            <table>
                <tr>
                    <th width="30%">Character</th>
                    <th width="25%">Class</th>
                    <th width="25%">Role</th>
                    <th></th>
                </tr>
            @foreach ($characters AS $character) 
                <tr character="{{ $character->id }}">
                    <td>
                        <span class="character-name">{{ $character->name }}</span>
                        <input class="input-name" value="{{ $character->name }}" />
                    </td>
                    <td>
                        <span class="character-class">{{ $character->class }}</span>
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
                        <span class="character-role">{{ $character->role }}</span>
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
                    <a onclick="addNew();"><i class="fa fa-plus"> <span>Add an Alt</span></i> </a>
                </td>   
            </tr>
            </table>
        </div>
    </div>
    @endif
</section>
@endsection

@section('scripts')
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
            row.find('span').hide();
            row.find('select, input').show();
        } else {
            resetRow(row);
        }
    }

    function addCharacter() {
        var userName = $('[name=name]');
        var userClass = $('[name=class]');
        var userRole = $('[name=role]');
        if (!checkFields({userName, userClass, userRole})) {
            return false;
        }
        
        var serverID = "{{ $server->id }}";
        var saveUrl = '/characters/save/' + serverID + '/0';
        saveUrl += '?name=' + userName.val();
        saveUrl += '&class=' + userClass.val();
        saveUrl += '&role=' + userRole.val();
        console.log(saveUrl);
        window.location = saveUrl;
    }

    function checkFields(fields) {
        var error = false;
        for (key in fields) {
            var field = fields[key];
            if (!field.val()) {
                field.css({'background': '#b00b00'});
                error = true;
            } else {
                field.css({'background': ''});
            }
        }
        return error ? false : true;
    }

    function saveCharacter(characterID) {
        var row = $('[character=' + characterID + ']');
        var nameInput = row.find('.input-name');
        if (!nameInput.val().length) {
            nameInput.css({'background': '#b00b00'});
            return false;
        }
        nameInput.css({'background': ''});

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
        row.find('span').show();
        row.find('select, input').hide();
    }
</script>
@endsection
