<div class="">
@foreach ($carryMarkList as $carryMark)
<div class="d-flex justify-content-between">
    <p class="mb-0 mt-0">{{ $carryMark['examName'] }} </p><strong class="justify-content-end">: {{ $carryMark['carryMark'] }}/{{ $carryMark['fullMark'] }}%</strong>
</div>
@endforeach
</div>
