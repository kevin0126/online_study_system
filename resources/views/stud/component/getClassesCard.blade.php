<div class="container">
    <div class="row">

    <div class="card-deck">
    @foreach($classes as $class)
        <div class="card classCard">
            <div class="card-body">
                <p class="card-text font-weight-bolder h6">{{ $class->classCode }}</p>
                <p class="card-title h5"><Strong>{{ $class->className }}</Strong></p>
                <p class="card-subtitle mb-2">{{ $class->facultyName }}</p>
                <a href="/home/class/stud/{{ $class->classID }}" class="stretched-link"></a>
            </div>
        </div>
    @endforeach
    </div>

    </div>
</div>
