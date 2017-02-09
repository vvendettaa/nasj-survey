@extends('landing.base.layout')

@section('header')

@endsection


@section('content')
<div class="row">
  <div class="col-md-12">

    <!-- Nav tabs -->
    <ul class="nav nav-tabs pull-right" role="tablist" id="question_section_tab">
      <?php $q_section_ids = [];?>
      @foreach($question_sections AS $question_section)
      <li role="presentation pull-right"><a href="#section-{{ $question_section->id }}" aria-controls="section-{{ $question_section->id }}" role="tab" data-toggle="tab">{{ $question_section->name }}</a></li>
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
@endsection


@section('after_scripts')
<script>
$(document).ready(function(){
  $('#question_section_tab a').click(function (e) {
  // e.preventDefault()
  var id = $(this).attr('href');
  $.ajax({
        type: "POST",
        url: 'getquestions',
        data: {section_id: id},
        success: function(data) {
            //return data;
            console.log(data);
            $(''+id).html(data);
        }
    });
  $(this).tab('show')
  console.log($(this).attr('href'));
});

});

function saveSection(section_id){
  var data = $("#section-form-"+section_id).serialize()+'&section_id='+section_id;
  console.log(data);
  $.ajax({
        type: "POST",
        url: 'savesection',
        data: data,
        success: function(data) {
            //return data;
            // console.log(data);
            $(''+id).html(data);
        }
    });
}

</script>
@endsection
