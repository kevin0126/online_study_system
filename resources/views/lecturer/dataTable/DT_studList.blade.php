
<table id="exampleTable" class="table table-striped table-bordered" cellspacing="0" style="width: 100%">
                            <thead>
                                <tr>
                                    <th scope="col">Student ID</th>
                                    <th scope="col">Student Name</th>
                                    <th scope="col">Contect</th>
                                    <th scope="col">E-mail</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                            @foreach($students as $student)
                                <tr>
                                    <td scope="row">{{ $student->studentID }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->contact }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td>
                                        <a class="btn btn-outline-primary btn-sm" type="button" data-toggle="modal" data-target="#removeComfirmModal" data-id='{{ $student->studentID }}'></i>REMOVE</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>


<script>
$(document).ready(function(){
    $('#exampleTable').DataTable({
        "dom": 'f<"toolbar">lrtpi'
    } );

    $("div.toolbar").html('<button class="btn btn-info mb-2 col-md-2 h-50" id="btnAdd" data-toggle="modal" type="button" data-target="#addStudModal">ADD</button>');
})
</script>
