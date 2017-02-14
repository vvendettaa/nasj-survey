<div class="row">
  <div class="col-md-12">

    <!-- Nav tabs -->
    <ul class="nav nav-tabs pull-right" role="tablist" id="question_section_tab">
      <?php $q_section_ids = [];?>
      @foreach($question_sections AS $question_section)
      <li role="presentation pull-right"><a href="#section-{{ $question_section->id }}" aria-controls="section-{{ $question_section->id }}" role="tab" data-toggle="tab">{{ $question_section->name }} <span class="label label-default" id="progress-section-{{ $question_section->id }}"></span></a></li>
      <?php array_push($q_section_ids, 'section-'.$question_section->id); ?>
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
