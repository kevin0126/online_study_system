
<table id="exampleTable" class="table table-striped table-bordered" cellspacing="0" style="width: 100%">
                            <thead>
                                <tr>
                                    <th scope="col">Student ID</th>
                                    <th scope="col">Student Name</th>
                                    <th scope="col">Contect</th>
                                    <th scope="col">E-mail</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                            @foreach($students as $student)
                                <tr>
                                    <td scope="row">{{ $student->idCode }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->contact }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td>
                                    @if($student->status == 1)
                                    <spam id="greenText">Active</spam>
                                    @else
                                    <spam id="redText">Inactive</spam>
                                    @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-outline-primary btn-sm" type="button" data-toggle="modal" data-target="#studModal" data-id='{{ $student->idCode }}' data-status='{{ $student->status }}'><i class="fa fa-pencil-square-o fa-lg" title="Detail"></i>Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>


<script>
$(document).ready(function(){
    $('#exampleTable').DataTable({
        "dom": 'f<"toolbar1">lrtpi'
    } );

    $("div.toolbar1").html('<a class="btn btn-primary btn-sm" style="width:9.5em;" href="/home/createStud"><strong>CREATE</strong></a>');
})
</script>
