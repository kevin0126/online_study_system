<div class="w-100 mb-1">
    <buttom class="btn btn-primary btn-sm" style="float:right; width:8em;" data-toggle="modal" data-target="#addGradingModal">ADD</buttom>
</div>

<table id="gradingTable" class="table table-striped table-bordered" cellspacing="0" style="width: 100%; margin:0px;">
    <thead>
        <tr>
            <th scope="col">Grading Type</th>
            <th scope="col">Mark / Percentage</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
    @if (count($records) < 1)
    </tbody>
    </table>
    <div class="bg-secondary w-100" style="height:50px;">
        <label class="text-center font-weight-bold text-white w-100 h-100">No Data Was Found</label>
    </div>
    @else

        @foreach($records as $record)
            <tr>
                <td scope="row">{{ $record->gradingType }}</td>
                <td>{{ $record->gradingPercentage }}</td>
                <td>
                    <a class="btn btn-outline-primary btn-sm btnGradRemove" id="btnGradRemove" type="button" data-name='{{ $record->gradingType }}' data-id='{{ $record->gradingID }}'>REMOVE</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endif
