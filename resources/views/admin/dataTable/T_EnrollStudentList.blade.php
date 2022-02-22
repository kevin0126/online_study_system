<button class="btn btn-info mb-2 col-md-2 h-50" data-toggle="modal" type="button" data-target="#addEnrollModal">ADD</button>
<div class="tablePanel border" style="height: 400px; background-color:lightgrey;">
    <table id="enrollStudent" class="table table-striped table-bordered"  cellspacing="0" style="width: 100%; margin:0px; background-color:white; table-layout: fixed;">
        <thead>
            <tr>
                <th scope="col">StudentID</th>
                <th scope="col">Student Name</th>
                <th scope="col">batch</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
    @if (isset($studrecords))

        @foreach($studrecords as $index2 => $studrecord)
            <tr>
                <td scope="row">{{ $studrecord['idCode'] }}</td>
                <td>{{ $studrecord['name'] }}</td>
                <td>{{ $studrecord['batch'] }}</td>
                <td>
                    <input class="btn btn-outline-primary btn-sm studRemove" value="Remove" type="button" data-id="{{ $index2 }}" >
                </td>
            </tr>
        @endforeach

    @endif
        </tbody>
    </table>
</div>
