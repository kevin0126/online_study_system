<button class="btn btn-info mb-2 col-md-2 h-50" data-toggle="modal" type="button" data-target="#addTImeModal">ADD</button>
<div class="tablePanel border" style="height: 400px; background-color:lightgrey;">
    <table id="timeTable" class="table table-striped table-bordered"  cellspacing="0" style="width: 100%; margin:0px; background-color:white; table-layout: fixed;">
        <thead>
            <tr>
                <th scope="col">Day</th>
                <th scope="col">Start Time</th>
                <th scope="col">Edit Time</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
    @if (isset($records))

        @foreach($records as $index => $record)
            <tr>
                <td scope="row">{{ $record['Day'] }}</td>
                <td>{{ $record['startTime'] }}</td>
                <td>{{ $record['endTime'] }}</td>
                <td>
                    <input class="btn btn-outline-primary btn-sm timeRemove" value="Remove" type="button" data-id="{{ $index }}" >
                </td>
            </tr>
        @endforeach

    @endif
        </tbody>
    </table>
</div>
