@extends('layouts.header')

@section('content')
<style>
.dataTables_filter {
   float: left;
   margin-left: 5px;
}

.dataTables_filter input{
    width:100%;
}
</style>

<h2 class="text-center font-weight-bold text-capitalize">Class Students List</h2>
<br>

<table id="exampleTable4" class="table table-striped table-bordered" cellspacing="0" style="width: 100%">
                            <thead>
                                <tr>
                                    <th scope="col">Student ID</th>
                                    <th scope="col">Student Name</th>
                                    <th scope="col">Contect</th>
                                    <th scope="col">E-mail</th>
                                </tr>
                            </thead>

                            <tbody>
                            @foreach($classStuds as $classStud)
                                <tr>
                                    <td scope="row">{{ $classStud->idCode }}</td>
                                    <td>{{ $classStud->name }}</td>
                                    <td>{{ $classStud->contact }}</td>
                                    <td>{{ $classStud->email }}</td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>



<script>
$(document).ready(function(){
    $('#exampleTable4').DataTable({
        "dom": 'frtpi'
    });
})
</script>
@endsection
