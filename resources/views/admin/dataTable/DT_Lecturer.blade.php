
<table id="l_exampleTable" class="table table-striped table-bordered" cellspacing="0" style="width: 100%">
                            <thead>
                                <tr></tr>
                                    <th scope="col">Lecturer ID</th>
                                    <th scope="col">Lecturer Name</th>
                                    <th scope="col">Contect</th>
                                    <th scope="col">E-mail</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                            @foreach($lecturers as $lecturer)
                                <tr>
                                    <td scope="row">{{ $lecturer->idCode }}</td>
                                    <td>{{ $lecturer->name }}</td>
                                    <td>{{ $lecturer->contact }}</td>
                                    <td>{{ $lecturer->email }}</td>
                                    <td>
                                    @if($lecturer->status == 1)
                                    <spam id="greenText">Active</spam>
                                    @else
                                    <spam id="redText">Inactive</spam>
                                    @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-outline-primary btn-sm" type="button" data-toggle="modal" data-target="#lecturModal" data-id='{{ $lecturer->idCode }}' data-status='{{ $lecturer->status }}'><i class="fa fa-pencil-square-o fa-lg" title="Detail"></i>Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>


<script>
$(document).ready(function(){
    $('#l_exampleTable').DataTable({
        "dom": 'f<"toolbar">lrtpi'
    } );

    $("div.toolbar").html('<a class="btn btn-primary btn-sm" style="width:9.5em;" href="/home/createLectur"><strong>CREATE</strong></a>');
})
</script>
