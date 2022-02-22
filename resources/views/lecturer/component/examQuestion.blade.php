<!-- here, the data haven pass yet -->
<div class="card mb-3">
    <div class="card-header questionHead" id="questionHead{{ $qNumb }}" data-id="{{ $qNumb }}" data-toggle="collapse" data-target="#collapse{{ $qNumb }}" href="#">

        <!-- question head -->
        <a class="card-link align-middle">
            <strong>Question #{{ $qNumb }}</strong>
        </a>

        <div class="float-right w-25" >
            <select id="qType{{ $qNumb }}" data-id="{{ $qNumb }}" class="form-control form-control-sm float-left w-75 qType">
                <option value="mcq">MCQ Question</option>
                <option value="subj">Subjective Question</option>
            </select>
            <div class="float-right align-middle">
                <i id="caret{{ $qNumb }}" class="fas fa-caret-up fa-lg"></i>
            </div>
        </div>

    </div>
    <div id="collapse{{ $qNumb }}" class="collapse">
        <div class="card-body">
            <div class="form-group">
                <label>Question</label>
                <textarea class="form-control" id="question{{ $qNumb }}" rows="2"></textarea>
            </div>

            <div class="mcqPanel hide current" id="mcqPanel{{ $qNumb }}">
                <div class="form-group">
                    <label>MCQ Choice</label>

                    <ul class="mcqul fadeMcq" id="mcqul{{ $qNumb }}">
                        <li class="show">
                            <div class="input-group input-group-sm col-sm-5 mb-1">
                                <input type="text" value="" name="q1mcq1" class="form-control" id="q{{ $qNumb }}mcq1">
                            </div>
                        </li>
                    </ul>
                    <ul>
                        <li>
                            <div class="col-sm-5">
                                <button type="buttom" class="btn btn-outline-primary btn-sm font-weight-bold addMcq" id="addMcq{{ $qNumb }}" style="width:30px;" data-id="{{ $qNumb }}"> + </button>
                                <button type="buttom" class="btn btn-outline-primary btn-sm font-weight-bold removeMcq" id="removeMcq{{ $qNumb }}" style="width:30px;" data-id="{{ $qNumb }}"> - </button>
                            </div>
                        </li>
                    </ul>

                </div>
            </div>

            <div class="form-group d-flex justify-content-end">
                    <div class="d-flex align-items-center">
                        <label>Mark:</label>
                    </div>

                    <div class="input-group col-sm-4 col-md-3 col-lg-2">
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-secondary markSub" type="button" data-id="{{ $qNumb }}" id="markSub{{ $qNumb }}">-</button>
                        </div>
                        <input type="number" class="form-control text-center" id="qMark{{ $qNumb }}" value="0" readonly>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary markAdd" type="button" data-id="{{ $qNumb }}" id="markAdd{{ $qNumb }}">+</button>
                        </div>
                    </div>

            </div>

        </div>
    </div>
</div>
