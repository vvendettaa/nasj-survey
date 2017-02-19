@extends('landing.base.layout')

@section('header')

@endsection


@section('content')
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

function saveSection(section_id, sec){
  var data = serializePost("#section-form-"+section_id);
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

</script>
@endsection
