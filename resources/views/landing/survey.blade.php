@extends('landing.base.layout')

@section('header')

@endsection


@section('content')

@if(isset($complete))
<div class="row" id="survey_submit" style="display: block;">
  <div class="col-md-8 col-md-offset-2">
     <input type="hidden" name="servey_id" id="survey_id" value="{{ $selected_survey->id }}" />
    <button type="button" class="btn btn-success col-md-12" onclick="saveSurvey('{{ $selected_survey->id }}')">Submit Survey</button>
  </div>
</div>

@else
<div class="row" id="survey_submit" style="display: none;">
  <div class="col-md-8 col-md-offset-2">
     <input type="hidden" name="servey_id" id="survey_id" value="{{ $selected_survey->id }}" />
    <button type="button" class="btn btn-success col-md-12" onclick="saveSurvey('{{ $selected_survey->id }}')">Submit Survey</button>
  </div>
</div>

@endif

<div class="row">
  <div class="col-md-12">

    <!-- Nav tabs -->
    <ul class="nav nav-tabs pull-right question_section_tab" role="tablist" id="question_section_tab">
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

  init_pnotify();

  // init_slider_q();

  getSectionProgress();

// question_section_tab
  $('.question_section_tab a').click(function (e) {
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
            init_slider_q();
        }
    });
  $(this).tab('show');
  // init_slider_q();

  // console.log($(this).attr('href'));
});

});

function saveSection(section_id){
  var data = serializePost("#section-form-"+section_id);
  console.log(data);
  $.ajax({
        type: "POST",
        section_id: section_id,
        url: 'savesection',
        data: data,
        success: function(data) {
            //return data;
            // console.log(data);
            if(data == '1'){
              new PNotify({
                  title: "Section Saved",
                  text: "Your answers has been saved.",
                  type: "success"
              });
              getQuestionSectionProgress(this.section_id);
              getSectionProgress();
              getProgress();
            } else{
              new PNotify({
                  title: "Section Not Saved",
                  text: "There has been an error, please try again.",
                  type: "warning"
              });
            }
        }
    });
    // var hrefid = $('#progress-s-section-'+section_id).closest('div[role="tabpanel"]').attr("id");
    // $('a[href="#'+hrefid+'"]').trigger('click');
  // $('#progress-section-'+sec).parent().trigger( "click" );
  // console.log('#progress-section-'+sec);
  // console.log($('#progress-section-'+sec).parent('a').html());


}

function getQuestionSectionProgress(section_id){
  $.ajax({
        type: "POST",
        section_id: section_id,
        data: {section_id: section_id},
        url: 'q-section-prog',

        success: function(data) {
            //return data;
            // console.log(data);
            $("#progress-section-counter-"+this.section_id).html(data);

            // $(''+id).html(data);
        }
    });
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
    var w = $("#progress").children('div').attr('style');
    var prog = parseInt(w.substr(7).slice(0, -2));
    if(prog == 100){
      $("#survey_submit").toggle(true);
    }
    // console.log(prog);
    // if($("#progress").children('<div>').c)
}

function serializePost(form) {
    var data = {};
    form = $(form).serializeArray();
    for (var i = form.length; i--;) {
        var name = form[i].name;
        var value = form[i].value;
        var index = name.indexOf('[]');
        if (index > -1) {
            name = name.substring(0, index);
            if (!(name in data)) {
                data[name] = [];
            }
            data[name].push(value);
        }
        else
            data[name] = value;
    }
    return data;
}

function init_slider_q(){
  // console.log('s');
  $('.slider_q').slider({
      	formatter: function(value) {
      		return 'Current value: ' + value;
      	}
      });

      $('.kv-gly-star').rating({
          containerClass: 'is-star',
          step: 1,
          showCaption: false
      });
}

function special_question_init(question_id){
  $.ajax({
            type: "POST",
            url: 'employees-directory',
            question_id: question_id,
            data: {question_id: question_id},
            success: function(data) {
                //return data;
                console.log(this.question_id);
                drawTree(data, this.question_id);
            }
        });
}

function drawTree(data, question_id){
    $('#tree-'+question_id).treeview({
      data: data,
      showIcon: true,
      showCheckbox: true,
      onNodeChecked: function(event, node) {
          $('#checkable-output').prepend('<p class="pull-left">' + node.text + ' was checked</p>');
      },
      onNodeUnchecked: function (event, node) {
          $('#checkable-output').prepend('<p>' + node.text + ' was unchecked</p>');
      }
    });
    $('#tree-'+question_id).treeview('collapseAll', { silent: true });
    $('#tree-'+question_id).on('nodeSelected', function(event, data) {
        console.log(data);
        $.ajax({
                  type: "POST",
                  url: 'employees-list',
                  question_id: question_id,
                  data: {list_id: data.id, question_id: question_id},
                  success: function(data) {
                      //return data;
                      // console.log(data);
                      $('#members-'+question_id).html(data);
                      // drawTree(data, this.question_id);
                  }
              });
        console.log(parent);
    });
  }

  function selectEmp(empId, quesId, e){
    e.preventDefault();
    $.ajax({
              type: "POST",
              url: 'question-panel',
              question_id: quesId,
              data: {emp_id: empId, question_id: quesId},
              success: function(data) {
                  //return data;
                  console.log(data);
                  $("#answers-"+this.question_id).append(data);
                  init_special_question_child();
                  console.log("#answers-"+this.question_id);
                  // $('#members-'+question_id).html(data);
                  // drawTree(data, this.question_id);
              }
          });

  }

  function init_special_question_child(){

    $('.special_question_section_tab a').click(function (e) {
    // e.preventDefault()
    var id = $(this).attr('href');
    var ids = id.split('-');
    var section_id = ids[2];
    var emp_id = ids[3];
    var question_id = ids[4];
    $.ajax({
          type: "POST",
          url: 'question-list',
          data: {section_id: section_id, emp_id: emp_id, question_id: question_id},
          success: function(data) {
              //return data;
              // console.log(data);
              $(''+ids[0]+'-'+ids[1]+'-'+ids[2]).html(data);
              console.log(''+ids[0]+'-'+ids[1]+'-'+ids[2]);
              init_slider_q();
          }
      });
    $(this).tab('show');
    // init_slider_q();

    // console.log($(this).attr('href'));
  });
  }

  function saveSurvey(survey_id){

    $.ajax({
          type: "POST",
          url: 'submit-survey',
          data: {survey_id: survey_id},
          success: function(data) {
              //return data;
              // console.log(data);
              if(data == '1'){
                new PNotify({
                    title: "Survey Saved",
                    text: "Your survey has been submitted.",
                    type: "success"
                });
                window.location.href = "/";
              } else{
                new PNotify({
                    title: "Survey Not Saved",
                    text: "There has been an error, please try again.",
                    type: "warning"
                });
              }
          }
      });


  }

  function init_pnotify(){
    PNotify.prototype.options.styling = "bootstrap3";
    PNotify.prototype.options.styling = "fontawesome";

    @foreach (Alert::getMessages() as $type => $messages)
        @foreach ($messages as $message)

            $(function(){
              new PNotify({
                // title: 'Regular Notice',
                text: "{{ $message }}",
                type: "{{ $type }}",
                icon: false
              });
            });

        @endforeach
    @endforeach
  }

</script>
@endsection
