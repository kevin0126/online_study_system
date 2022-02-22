<select class="custom-select" size="5" id="restoreListItem" name="restoreListItem">

    @foreach($restoreLists as $restorelist)
        <option value="{{ $restorelist->bktimeID }}">{{ $restorelist->name }}</option>
    @endforeach

</select>
