<form id="raid-form" class="validate">
    <input type="hidden" name="guildID" value="{{ $server->id ?: '' }}" />
    <input type="hidden" name="raidID" value="{{ $raid->id ?: '' }}" />
    @if ($settings->faction == 'Both')
    <div class="gb-row">
        <label for="faction">Faction</label>
        <select required name="faction">
            <option value="Alliance">Alliance</option>
            <option value="Horde">Horde</option>
        </select>
    </div>
    @else
        <input type="hidden" name="faction" value="{{ $settings->faction }}" />
    @endif
    <div class="gb-row">
        <label for="title">Title</label>
        <input onkeyup="goodbot.raid.suggestChannel();" required name="title" value="{{ $raid->title ?: $raid->name ?: $raid->raid }}"/>
    </div>
    <div class="gb-row">
        <label for="raid">Raid</label>
        <select required name="raid">
            <option value="">Please select a raid..</option>
            @foreach ($raids AS $expansion => $expacRaids) 
                <optgroup label="{{ $expansion }}">
                @foreach ($expacRaids AS $key => $raidName)
                <option value="{{ $key }}"
                    @if ($key == strtolower($raid->raid)) 
                        selected
                    @endif
                >{{ $raidName }}</option>
                @endforeach
            @endforeach
            </optgroup>
        </select>
    </div>
    <div class="gb-row">
        <label for="date">Date</label>
        <input onchange="goodbot.raid.suggestChannel();" onkeyup="goodbot.raid.suggestChannel();" required name="date" class="date" value="{{ $raid->date }}" />
    </div>
    <div class="gb-row">
        <label for="time">Time</label>
        <input required name="time" class="time" value="{{ $raid->time }}" />
    </div>
    <div class="gb-row">
        <label for="description">Description</label>
        <textarea required name="description" />{{ $raid->description }}</textarea>
    </div>
    <div class="gb-row">
        <label for="channel">Channel Name</label>
        <input required id="channel" name="channel" value="{{ property_exists($channel, 'name') ? $channel->name : '' }}"/>
    </div>
    <div class="gb-row">
        <label for="color">Sidebar Color</label>
        <input required name="color" class="spectrum" value="{{ $raid->color ?: '#FF9900' }}"/>
    </div>
    <div class="gb-row">
        <label for="confirmation">Confirmation Mode</label>
        <select name="confirmation">
            <option value="0">no</option>
            <option value="1"
            @if ($raid->confirmation) selected @endif
            >yes</option>
        </select>
    </div>
    <div class="gb-row">
        <label for="softreserve">Soft Reserves</label>
        <select name="softreserve">
            <option value="0">no</option>
            <option value="1"
            @if ($raid->softreserve) selected @endif
            >yes</option>
        </select>
    </div>
    @csrf
    <div class="gb-row">
        <button>Save</button>
    </div>
</form> 
