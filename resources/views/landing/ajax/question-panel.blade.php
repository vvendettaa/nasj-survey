<div class="panel panel-default">
    <div class="panel-heading with-border">
        <div class="panel-title"><a onclick="" style="color: #e22620;" class="collapsed" role="button" data-toggle="collapse" data-parent="" href="#collapse-e-{{$emp['id']}}" aria-expanded="false" aria-controls="collapse-e-{{$emp['id']}}">{{$emp['name']}}</a></div>
    </div>

    <div id="collapse-e-{{$emp['id']}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-e-{{$emp['id']}}">
    <div class="panel-body">
      <div class="row">
        <div class="col-md-12">

          <!-- Nav tabs -->
          <ul class="nav nav-tabs pull-right special_question_section_tab" role="tablist" id="">
            <?php $q_section_ids = [];?>
            @foreach($question_sections AS $question_section)
            <li role="presentation pull-right"><a href="#section-emp-{{ $question_section->id }}-{{ $emp['id']}}-{{ $question_id }}" aria-controls="section-emp-{{ $question_section->id }}" role="tab" data-toggle="tab">{{ $question_section->name }} <span class="label label-default" id="progress-section-emp-{{ $question_section->id }}"></span></a></li>
            <?php array_push($q_section_ids, 'section-emp-'.$question_section->id); ?>
            @endforeach
          </ul>

          <!-- Tab panes -->
          <div class="tab-content">
            @foreach($q_section_ids AS $id)
            <div role="tabpanel" class="tab-pane fade" id="{{ $id }}">...</div>
            @endforeach
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
