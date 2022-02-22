<select class="custom-select" size="5" id="bkListItem" name="bkListItem">

    @foreach($bkLists as $bklist)
        <option value="{{ $bklist->bktimeID }}">{{ $bklist->name }}</option>
    @endforeach

</select>
