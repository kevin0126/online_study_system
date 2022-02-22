@extends('layouts.header')

@section('content')
<style>
body,html,.panel_main{
    height:100%;
    background: lightblue;
}

.innerCard{
    background: skyblue;
}

</style>

<div id="panel_main" class="panel_main">
    <div class="row h-100">
        <div class="col-sm-12 my-auto">
            <div class="container">
                <div class="col-sm-8 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            We have receive your submission, Thank You for your Cooperation<br/>
                            The page will redirect to home page after <strong>5 Seconds</strong>.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
setTimeout(function(){
    window.location.href = "/home";
}, 5000);
</script>

@endsection
