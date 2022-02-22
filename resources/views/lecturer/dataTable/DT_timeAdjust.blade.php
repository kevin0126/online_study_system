
<table id="exampleTable" class="table table-striped table-bordered" cellspacing="0" style="width: 100%">
                            <thead>
                                <tr>
                                    <th scope="col">TimeAdj ID</th>
                                    <th scope="col">Class Code</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                            @foreach($timeAdjs as $timeAdj)
                                <tr>
                                    <td scope="row">{{ $timeAdj->timeAdjID }}</td>
                                    <td>{{ $timeAdj->classCode }}</td>
                                    <td>{{ $timeAdj->type }}</td>
                                    <td>{{ $timeAdj->created_at }}</td>
                                    <td>
                                        <a class="btn btn-outline-primary btn-sm" type="button" data-toggle="modal" data-target="#timeAdjModal" data-id='{{ $timeAdj->timeAdjID }}'></i>DETAIL</a>
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

    $("div.toolbar").html('<a class="btn btn-info btn-sm mb-2" id="btnAdd" type="button" href="/home/createTimeAdj">ADD</a>');
})
</script>
