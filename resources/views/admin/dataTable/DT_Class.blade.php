
<table id="c_exampleTable" class="table table-striped table-bordered" cellspacing="0" style="width: 100%">
                            <thead>
                                <tr></tr>
                                    <th scope="col">Class ID</th>
                                    <th scope="col">Class Code</th>
                                    <th scope="col">Class Name</th>
                                    <th scope="col">Assign Lecturer</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                            @foreach($classes as $class)
                                <tr>
                                    <td scope="row">{{ $class->classID }}</td>
                                    <td>{{ $class->classCode }}</td>
                                    <td>{{ $class->className }}</td>
                                    <td>{{ $class->name }}</td>
                                    <td>
                                    @if( $class->status == 1 )
                                    <spam id="greenText">Active</spam>
                                    @else
                                    <spam id="redText">Inactive</spam>
                                    @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-outline-primary btn-sm" type="button" data-toggle="modal" data-target="#classModal" data-id='{{ $class->classID }}' data-status='{{ $class->status }}'><i class="fa fa-pencil-square-o fa-lg" title="Detail"></i>Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>


<script>
$(document).ready(function(){
    var tools4 = `
    <div class="dropdown">
        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width:8em;">
            <strong>
                OPTIONS
            </strong>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdown">
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#comfirmModal">REST</a>
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#backupModal">BACKUP</a>
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#restoreModal">RESTORE</a>
        </div>
    </div>
    `;

    $('#c_exampleTable').DataTable({
        "dom": 'f<"toolbar3"><"toolbar4">lrtpi'
    } );

    //$("div.toolbar3").html('<button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#comfirmModal" style="width:9.5em;"><strong>REST</strong></button>');
    $("div.toolbar3").html(tools4);
    $("div.toolbar4").html('<a class="btn btn-primary btn-sm" style="width:9.5em;" href="/home/createClass"><strong>CREATE</strong></a>');
})
</script>
