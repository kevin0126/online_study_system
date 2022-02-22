
<div class="cd-schedule cd-schedule--loading margin-top-lg margin-bottom-lg js-cd-schedule">
    <div class="cd-schedule__timeline">
      <ul>
        <li><span>09:00</span></li>
        <li><span>09:30</span></li>
        <li><span>10:00</span></li>
        <li><span>10:30</span></li>
        <li><span>11:00</span></li>
        <li><span>11:30</span></li>
        <li><span>12:00</span></li>
        <li><span>12:30</span></li>
        <li><span>13:00</span></li>
        <li><span>13:30</span></li>
        <li><span>14:00</span></li>
        <li><span>14:30</span></li>
        <li><span>15:00</span></li>
        <li><span>15:30</span></li>
        <li><span>16:00</span></li>
        <li><span>16:30</span></li>
        <li><span>17:00</span></li>
        <li><span>17:30</span></li>
        <li><span>18:00</span></li>
      </ul>
    </div> <!-- .cd-schedule__timeline -->

    <div class="cd-schedule__events">
      <ul>

        @foreach($timeSets as $index => $timeSet)

        <li class="cd-schedule__group">
          <div class="cd-schedule__top-info"><span>{{ $timeSet[2] }} ({{ $timeSet[0] }})</span></div>

          <ul>
            @foreach($timeSet[1] as $index2 => $time)
            <li class="cd-schedule__event">
              <a class="t{{ $index+1 }}s{{ $index2+1 }}" id="t{{ $index+1 }}s{{ $index2+1 }}" data-start='{{ substr($time->startTime, 0, -3) }}' data-end='{{ substr($time->endTime, 0, -3) }}' data-content="event-abs-circuit" data-event="event-1" href="#0">
                <span class="h7 text-white font-weight-bold font-italic">{{ $time->className }}</span>
              </a>
            </li>
            @endforeach
          </ul>
        </li>

        @endforeach

      </ul>
    </div>

    <div class="cd-schedule-modal">
      <header class="cd-schedule-modal__header">
        <div class="cd-schedule-modal__content">
          <span class="cd-schedule-modal__date"></span>
          <h3 class="cd-schedule-modal__name"></h3>
        </div>

        <div class="cd-schedule-modal__header-bg"></div>
      </header>

      <div class="cd-schedule-modal__body">
        <div class="cd-schedule-modal__event-info"></div>
        <div class="cd-schedule-modal__body-bg"></div>
      </div>

      <a href="#0" class="cd-schedule-modal__close text-replace">Close</a>
    </div>

    <div class="cd-schedule__cover-layer"></div>
</div>

<script src="{{ asset('js/main.js') }}"></script>

<script>
function assignColor(){
    var tempHolder = [];
    var timeSlot = {!! json_encode($timeSets, JSON_HEX_TAG) !!};

    timeSlot.forEach(function(value, index){
        if(value[1].length > 0){
            value[1].forEach(function(value2, index2){
                //alert(value2['classID']);
                var compareIndex = tempHolder.indexOf(value2['classID']);
                if(compareIndex !== -1){
                    //alert('#t'+(index+1)+'s'+(index2+1));
                    $('#t'+(index+1)+'s'+(index2+1)).attr('data-event', 'event-'+(compareIndex+1));
                    //alert($('#t'+(index+1)+'s'+(index2+1)).data('event'));
                }else{
                    tempHolder.push(value2['classID']);
                    //here
                    $('#t'+(index+1)+'s'+(index2+1)).attr('data-event', 'event-'+(tempHolder.length));
                }
            })

        }

    })
}
</script>
