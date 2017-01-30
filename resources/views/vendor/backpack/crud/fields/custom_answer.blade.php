<!-- text input -->
<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>
      <div class="custom_answer col-md-12">
          <div class="entry input-group col-md-5 entry_custom">
            <input class="form-control" name="fields[]" type="text" placeholder="Type something" />
        	<span class="input-group-btn">
                <button class="btn btn-success btn-add" type="button">
                    <span class="glyphicon glyphicon-plus"></span>
                </button>
            </span>
        </div>
      </div>
</div>


{{-- star
<div class="entry input-group col-md-5 entry_custom">
  <input class="form-control" name="fields[]" type="text" placeholder="Type something" />
<span class="input-group-btn">
  <button class="btn btn-success btn-add" type="button" disabled="true">
          <span class="glyphicon glyphicon-star"></span>
  </button?
  </span>
</div> --}}


{{-- FIELD EXTRA CSS  --}}
{{-- push things in the after_styles section --}}

     @push('crud_fields_styles')
        <!-- no styles -->
        <style>
        .entry:not(:first-of-type)
        {
            /*margin-top: 10px;*/
        }
        .entry{
          float: inherit !important;
          margin-left: 6px;
          margin-bottom: 6px;
        }
        </style>
    @endpush


{{-- FIELD EXTRA JS --}}
{{-- push things in the after_scripts section --}}

    @push('crud_fields_scripts')
        <!-- no scripts -->
        <script>
        $(document).ready(function(){
          $(document).on('click', '.btn-add', function(e)
          {
              e.preventDefault();

              var controlForm = $('.custom_answer'),
                  currentEntry = $(this).parents('.entry:first'),
                  newEntry = $(currentEntry.clone()).appendTo(controlForm);

              newEntry.find('input').val('');
              controlForm.find('.entry:not(:last) .btn-add')
                  .removeClass('btn-add').addClass('btn-remove')
                  .removeClass('btn-success').addClass('btn-danger')
                  .html('<span class="glyphicon glyphicon-minus"></span>');
          }).on('click', '.btn-remove', function(e)
          {
          $(this).parents('.entry:first').remove();

          e.preventDefault();
          return false;
        });

        var selected_type = $('#type_sel').val();
        $('#parent_sel').parent().hide();
        $('#type2_sel').parent().hide();
        if(selected_type == 6){
          $('#parent_sel').parent().show();
          $('#type2_sel').parent().show();
        } else if(selected_type == 5){
          $('.custom_answer').parent().hide();
        }



          bind_type_sel();


      });

      function bind_type_sel(){
        $('#type_sel').change(function(){
          console.log($('#type_sel').val());
          $('.custom_answer').parent().show();
          $('#parent_sel').parent().hide();
          $('#type2_sel').parent().hide();
          switch($('#type_sel').val()) {
              case '1':
                  $('.custom_answer').html('<div class="entry input-group col-md-5 entry_custom"><input class="form-control" name="fields[]" type="text" placeholder="Type something" /><span class="input-group-btn"><button class="btn btn-success btn-add" type="button"><span class="glyphicon glyphicon-plus"></span></button></span></div>');
                  break;
              case '2':
                  $('.custom_answer').html('<div class="entry input-group col-md-5 entry_custom"><input class="form-control" name="fields[]" type="text" placeholder="Type something" /><span class="input-group-btn"><button class="btn btn-success btn-add" type="button"><span class="glyphicon glyphicon-plus"></span></button></span></div>');
                  break;
              case '3':
                  $('.custom_answer').html('<div class="entry input-group col-md-5 entry_custom"><input class="form-control" name="fields[]" type="text" placeholder="1-10" /><span class="input-group-btn"><button class="btn btn-success btn-add" type="button" disabled="true"><span class="glyphicon glyphicon-cog"></span></button></span></div>');
                  break;
              case '4':
                  $('.custom_answer').html('<div class="entry input-group col-md-5 entry_custom"><input class="form-control" name="fields[]" type="text" placeholder="How many stars?" /><span class="input-group-btn"><button class="btn btn-success btn-add" type="button" disabled="true"><span class="glyphicon glyphicon-star"></span></button></span></div>');
                  break;
              case '5':
                  $('.custom_answer').parent().hide();
                  break;
              case '6':
                  $('#parent_sel').parent().show();
                  $('#type2_sel').parent().show();
                  // ?swap_type_ids();
                  break;
              default:
                  $('.custom_answer').html('<div class="entry input-group col-md-5 entry_custom"><input class="form-control" name="fields[]" type="text" placeholder="Type something" /><span class="input-group-btn"><button class="btn btn-success btn-add" type="button"><span class="glyphicon glyphicon-plus"></span></button></span></div>');
          }
          if($(this).val() == 6){
            $('#parent_sel').parent().show();
          }

        });

          $('#type2_sel').change(function(){
            $('#parent_sel').parent().show();
            switch($('#type2_sel').val()) {
                case '1':
                    $('.custom_answer').html('<div class="entry input-group col-md-5 entry_custom"><input class="form-control" name="fields[]" type="text" placeholder="Type something" /><span class="input-group-btn"><button class="btn btn-success btn-add" type="button"><span class="glyphicon glyphicon-plus"></span></button></span></div>');
                    break;
                case '2':
                    $('.custom_answer').html('<div class="entry input-group col-md-5 entry_custom"><input class="form-control" name="fields[]" type="text" placeholder="Type something" /><span class="input-group-btn"><button class="btn btn-success btn-add" type="button"><span class="glyphicon glyphicon-plus"></span></button></span></div>');
                    break;
                case '3':
                    $('.custom_answer').html('<div class="entry input-group col-md-5 entry_custom"><input class="form-control" name="fields[]" type="text" placeholder="1-10" /><span class="input-group-btn"><button class="btn btn-success btn-add" type="button" disabled="true"><span class="glyphicon glyphicon-cog"></span></button></span></div>');
                    break;
                case '4':
                    $('.custom_answer').html('<div class="entry input-group col-md-5 entry_custom"><input class="form-control" name="fields[]" type="text" placeholder="How many stars?" /><span class="input-group-btn"><button class="btn btn-success btn-add" type="button" disabled="true"><span class="glyphicon glyphicon-star"></span></button></span></div>');
                    break;
                case '5':
                    // $('.custom_answer').parent().hide();
                    break;
                case '6':
                    // $('#parent_sel').parent().show();
                    // $('#type2_sel').parent().show();
                    // ?swap_type_ids();
                    break;
                default:
                    $('.custom_answer').html('<div class="entry input-group col-md-5 entry_custom"><input class="form-control" name="fields[]" type="text" placeholder="Type something" /><span class="input-group-btn"><button class="btn btn-success btn-add" type="button"><span class="glyphicon glyphicon-plus"></span></button></span></div>');
            }
          });
      }

      function swap_type_ids(){
        var e1 = $('#type_sel');
        var e2 = $('#type2_sel');
        e1.attr('id','type2_sel');
        e2.attr('id','type_sel');
      }

        </script>
    @endpush


{{-- Note: you can use @if ($crud->checkIfFieldIsFirstOfItsType($field, $fields)) to only load some CSS/JS once, even though there are multiple instances of it --}}
