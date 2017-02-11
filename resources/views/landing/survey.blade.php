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
@endsection


@section('after_scripts')
<script>
$(document).ready(function(){

  getSectionProgress();

  $('#question_section_tab a').click(function (e) {
  // e.preventDefault()
  var id = $(this).attr('href');
  $.ajax({
        type: "POST",
        url: 'getquestions',
        data: {section_id: id},
        success: function(data) {
            //return data;
            // console.log(data);
            $(''+id).html(data);
        }
    });
  $(this).tab('show');

  console.log($(this).attr('href'));
});

});

function saveSection(section_id, sec){
  var data = $("#section-form-"+section_id).serialize()+'&section_id='+section_id;
  console.log(data);
  $.ajax({
        type: "POST",
        url: 'savesection',
        data: data,
        success: function(data) {
            //return data;
            // console.log(data);
            if(data == '1'){
              alert('Your answers has been saved.');
            }
        }
    });
  $('#progress-section-'+sec).parent().trigger( "click" );
  console.log('#progress-section-'+sec);
  console.log($('#progress-section-'+sec).parent('a').html());
  getSectionProgress();
  getProgress();

}

function getSectionProgress(){
  $.ajax({
        type: "POST",
        url: 'sectionprogress',

        success: function(data) {
            //return data;
            // console.log(data);
            data = $.parseJSON(data);
            $.each(data, function(k, v) {
                $('#'+k).html(v);
            });

            // $(''+id).html(data);
        }
    });
}

function getProgress(){
  $.ajax({
        type: "POST",
        url: 'progress',

        success: function(data) {
            //return data;
            $('#progress').html(data);

            // $(''+id).html(data);
        }
    });
}

</script>
@endsection
