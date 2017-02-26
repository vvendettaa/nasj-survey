<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Survey;
use App\Models\Question;
use App\Models\Question_type;
use App\Models\Question_section;
use App\Models\Answer;
use App\Models\Employee;
use App\Models\Submitted_survey;

class SurveyController extends Controller
{
  protected $data = []; // the information we send to the view
  protected $user;
  protected $user_role;

  /**
   * Create a new controller instance.
   */
  public function __construct()
  {
      // $this->middleware('role:super_admin|admin|cxo|manager');
      $this->middleware(function ($request, $next) {
        if(\Auth::user()){
            $this->user = \Auth::user();
            $this->user_role = $this->user->roles()->get()[0];
            $submitted_surveys = Submitted_survey::where('user_id', $this->user->id)->get()->pluck('survey_id')->toArray();
            $this->data['surveys'] = Survey::where('start_time', '<=', date('Y-m-d H:i:s'))->where('end_time', '>', date('Y-m-d H:i:s'))->whereNotIn('id', $submitted_surveys)->get()->toArray();
            $this->data['selected_survey'] = (session('selected_survey'))? session('selected_survey') : new Survey();
            // dd($request);
          } else{
            $this->user = false;
            $this->user_role = 'guest';

            $this->data['surveys'] = [];
          }
            return $next($request);
        });
  }

  public function index($slug = ''){
    session(['selected_survey' => new Survey()]);
    $this->data['selected_survey'] = session('selected_survey');

    return view('landing.home', $this->data);
  }

  public function getSurvey($slug){

        $this->data['selected_survey'] = Survey::where('slug', $slug)->first();
        session(['selected_survey' => $this->data['selected_survey']]);
        $this->data['question_sections'] = Question_section::
                              where('survey_id', $this->data['selected_survey']->id)
                              ->where('parent_id', '0')
                              ->orderBy('id', 'desc')
                              ->get();
        $answered_c = (int)Answer::where('user_id', $this->user->id)->where('survey_id', $this->data['selected_survey']->id)->count();
        $total = (int)Question::where('survey_id', $this->data['selected_survey']->id)->count();

        if($total != 0){
          $this->data['progress'] = (int)($answered_c / $total * 100);
        } else{
          $this->data['progress'] = 0;
        }

        if($total == $answered_c){
          $this->data['progress'] = 100;
          $this->data['complete'] = true;
        }


        // $this->data['questions'] = Question::where('')

        return view('landing.survey', $this->data);

  }

  public function getQuestions(Request $request){
    $question_section_id = substr($request->input('section_id'), 9);
    // $sections = Question_section::where('parent_id', $question_section_id)->get();
    // $questions = Question::
    //   whereHas('question_section', function ($query) use( $question_section_id) {
    //     $query->where('parent_id', $question_section_id);
    //   })->with(array('answers' => function($query) {
    //     $query->where('user_id', $this->user->id);
    //   }))->
    //   orderBy('question_section_id', 'ASC')->with('question_section')->get()->toArray();

      $questions = Question_section::where('parent_id', $question_section_id)->orWhere('id', $question_section_id)
      ->whereHas('questions', function($query) {
        $query->with(['answers' => function($query) {
          $query->where('user_id', $this->user->id);
        }]);
      })->with(['questions' => function($query) {
          $query->where('parent_id', '0');
      }])->with(['questions.answers' => function($query) {
          $query->where('user_id', $this->user->id);
      }])->get()->toArray();




      //dd($answered_questions);


      $this->data['results'] = '<div class="row"><div class="panel-group" id="questions" role="tablist" aria-multiselectable="true">';
      $result_arr = [];
      foreach ($questions as $section) {
        $answered_questions_section = Answer::where('user_id', $this->user->id)->whereHas('question', function($query) use($section){
          $query->where('question_section_id',$section['id']);
        })->count();
        $this->data['results'] .= '<div class="col-md-12 flip" style="margin-bottom:10px;" id="progress-s-section-'.$section['id'].'">
        <div class="panel panel-info">
          <div class="panel-heading" role="tab" id="heading-'.$section['id'].'">
          <div class="panel-title">
            <h4>
              <a class="collapsed" role="button" data-toggle="collapse" data-parent="#questions" href="#collapse-'.$section['id'].'" aria-expanded="false" aria-controls="collapse-'.$section['id'].'">
                '.$section['name'].'
              </a>
              <span class="label label-default pull-left">
                <span class="label label-success pull-left">'.$answered_questions_section.'</span><span class="label label-info pull-left">'.count($section['questions']).'</span>
              </span>
            </h4>
          </div>
        </div>
        <div id="collapse-'.$section['id'].'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-'.$section['id'].'">
        <div class="panel-body"><form class="form-horizontal" role="form" id="section-form-'.$section['id'].'">';
        foreach($section['questions'] AS $question){
          $this->data['results'] .= '<div class="row">';
          switch ($question['question_type_id']) {
            //multiple radio
            case '1':
              $this->data['results'] .= $this->radio_question($question);
              break;

              //multiple checkbox
              case '2':
                $this->data['results'] .= $this->checkbox_question($question);
              break;
              //slider Number
              case '3':
                $this->data['results'] .= $this->slider_question($question);
              break;
              //slider rating
              case '4':
                $this->data['results'] .= $this->rating_question($question);
              break;

              //special question parent
              case '5':
                $this->data['results'] .= $this->special_question($question);
              break;
              //special question child
              // case '6':
              //
              // break;

              //case 7 and default textarea
              default:
                $this->data['results'] .= $this->textarea_question($question);
              break;
          }
          $this->data['results'] .= '
              </div>
            ';
        }
        $this->data['results'] .= '
        <div class="form-group" style="margin-top:20px;">
           <div class="col-md-8 col-md-offset-2">
              <input type="hidden" name="section_id" value="'.$question_section_id.'" />
             <button type="button" class="btn btn-success col-md-12" onclick="saveSection('.$section['id'].')">Save</button>
           </div>
          </div>
            </form></div></div></div></div>';
      }
      $this->data['results'] .= '</div></div></div>';

    // dd($questions);
    return $this->data['results'];
  }

  public function saveSection(Request $request)
  {
    $section = Question_section::where('id', $request->input('section_id'))->first();
    $request->request->remove('section_id');
    foreach ($request->input() as $key => $value) {
      if(is_array($value)){
        $tmp_0 = [];
        $tmp_1 = [];
        foreach ($value as $v) {
          $tmp = explode(',', $v);
          $tmp[1] = (isset($tmp[1]))? $tmp[1] : $tmp[0];
          array_push($tmp_0, $tmp[0]);
          array_push($tmp_1, $tmp[1]);
        }
        $v = [json_encode($tmp_0), json_encode($tmp_1)];
      } else{
        $v = explode(',',$value);
      }

      Answer::updateOrCreate(['user_id' => $this->user->id, 'survey_id' => $section->survey_id, 'question_id' => substr($key, 9)] , ['answer_value' => $v[1], 'answer_text' => $v[0]]);
    }
    return 1;
  }

  public function getSectionProgress(Request $request)
  {
        $data = [];
        if(!empty($this->data['selected_survey']->id)){
          $sections = Question_section::where('parent_id', 0)->where('survey_id', $this->data['selected_survey']->id)->get()->pluck('id')->toArray();
          foreach ($sections as $question_section_id) {
              $section_ids = Question_section::where('parent_id', $question_section_id)->get()->pluck('id')->toArray();
              $answered = Answer::where('user_id', $this->user->id)->whereHas('question', function($query) use($section_ids){
                $query->whereIn('question_section_id', $section_ids);
              })->count();
              $total = Question::whereIn('question_section_id', $section_ids)->count();
              // dd(Question_section::where('parent_id', $question_section_id)->get()->pluck('id')->toArray());
              // $this->data[$request->input('section_id')] = $answered . ' / ' . $total;
              $data['progress-section-'.$question_section_id] = '<span class="label label-success">'.$answered.'</span>/<span class="label label-info">'.$total.'</span>';
          }
          return json_encode($data);
    }

  }

  public function getSurveyProgress()
  {
    if(!empty($this->data['selected_survey']->id)){
      $total = (int)Question::where('survey_id', $this->data['selected_survey']->id)->count();
      $ans = (int)Answer::where('user_id', $this->user->id)->where('survey_id', $this->data['selected_survey']->id)->count();
      $progress = (int)($ans / $total * 100);

      if($total == $ans){
        $progress = 100;
      }
      $data = '<div class="progress-bar progress-bar-info" style="width: '.$progress.'%;">Progress: '.$progress.'%</div>
          <span class="" style="">'.$progress.'%</span>';
          return $data;
      }

  }


  private function radio_question($question)
  {
    $results = '<div class="col-md-12" style="margin-bottom:10px;">
          <div class="form-group-lg">
            <label class="col-md-12 control-label"><strong> - '.$question['question'].'</strong></label>
            <div class="col-md-12">
              ';

    $count = 0;
    $answers_l = (is_array($question['answer']))? $question['answer'] : json_decode($question['answer']);
      foreach($answers_l AS $answer){
        $checked = (isset($question['answers'][0]['answer_value']) && (array_search((string)$count, json_decode($question['answers'][0]['answer_value'])) !== false))? 'checked="checked"' : '';
        $results .= '<div class="radio-inline"><label>
          <input type="radio" name="question_'.$question['id'].'[]" id="question_'.$question['id'].'_'.$count.'" value="'.$answer.','.$count++.'" '.$checked.'>
          '.$answer.'
        </label></div>';
      }
      $results .= '</div>
                </div>
              </div>';

     return $results;
  }

  private function checkbox_question($question)
  {
    $results = '<div class="col-md-12" style="margin-bottom:10px;">
          <div class="form-group-lg">
            <label class="col-md-12 control-label"><strong> - '.$question['question'].'</strong></label>
            <div class="col-md-12">
              ';
    $count = 0;
    $answers_l = (is_array($question['answer']))? $question['answer'] : json_decode($question['answer']);
      foreach($answers_l AS $answer){
        $checked = (isset($question['answers'][0]['answer_value']) && (array_search($count, json_decode($question['answers'][0]['answer_value'])) !== false))? 'checked="checked"' : '';
        $results .= '<div class="checkbox-inline"><label>
          <input type="checkbox" name="question_'.$question['id'].'[]" id="question_'.$question['id'].'_'.$count.'" value="'.$answer.','.$count++.'" '.$checked.'>
          '.$answer.'
        </label></div>';
      }
      $results .= '</div>
                </div>
              </div>';

      return $results;

  }

  private function slider_question($question)
  {

    $results = '<div class="col-md-12" style="margin-bottom:10px;">
          <div class="form-group-lg">
            <label class="col-md-12 control-label"><strong> - '.$question['question'].'</strong></label>
            <div class="col-md-12">
              ';
    $count = 0;
    $answers_l = (is_array($question['answer']))? $question['answer'] : json_decode($question['answer']);
      foreach($answers_l AS $answer){
        $a = explode('-',$answer);
        $value = (isset($question['answers'][0]['answer_value']))? json_decode($question['answers'][0]['answer_value'])[0] : '';
        $results .= '
          <input class="form-control slider_q" data-slider-id="question_'.$question['id'].'_'.$count.'Slider" type="text" data-slider-min="'.$a[0].'" data-slider-step="1" data-slider-max="'.$a[1].'" name="question_'.$question['id'].'[]" id="question_'.$question['id'].'_'.$count.'" data-slider-value="'.$value.'" />
        ';
      }
      $results .= '</div>
                </div>
              </div>';
      return $results;
  }

  private function rating_question($question)
  {
    $results = '<div class="col-md-12" style="margin-bottom:10px;">
          <div class="form-group-lg">
            <label class="col-md-12 control-label"><strong> - '.$question['question'].'</strong></label>
            <div class="col-md-12">
              ';
    $count = 0;
    $answers_l = (is_array($question['answer']))? $question['answer'] : json_decode($question['answer']);
      foreach($answers_l AS $answer){
        $a = explode('-',$answer);
        $value = (isset($question['answers'][0]['answer_value']))? json_decode($question['answers'][0]['answer_value'])[0] : '';
        $results .= '
          <input class="form-control kv-gly-star rating-loading" data-slider-id="question_'.$question['id'].'_'.$count.'Slider" type="text" dir="rtl" data-size="xs" name="question_'.$question['id'].'[]" id="question_'.$question['id'].'_'.$count.'" title="" value="'.$value.'" />
        ';
      }
      $results .= '</div>
                </div>
              </div>';
      return $results;
  }

  private function special_question($question)
  {
    $results = '<input type="hidden" class="special-question-exsists" value="'.$question['id'].'" />
    <div class="col-md-12" style="margin-bottom:10px;">
          <div class="form-group-lg">
            <label class="col-md-12 control-label"><strong> - '.$question['question'].'</strong></label>
            </div>
            </div>
    <div class="col-md-12 flip" style="margin-bottom:10px;">
        <div class="panel panel-default">
            <div class="panel-heading with-border">
                <div class="panel-title"><a onclick="special_question_init('.$question['id'].')" style="color: #e22620;" class="collapsed" role="button" data-toggle="collapse" data-parent="#questions" href="#collapse-'.$question['id'].'" aria-expanded="false" aria-controls="collapse-'.$question['id'].'">Answer</a></div>
            </div>

            <div id="collapse-'.$question['id'].'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-'.$question['id'].'">
            <div class="panel-body">
              <div class="row" id="row-id-q-'.$question['id'].'">
                <div class="col-lg-2 flip tree" id="tree-'.$question['id'].'">

                </div>
                <div class="col-md-3">
          <!-- USERS LIST -->
          <div class="panel panel-danger">
            <div class="panel-heading with-border">
              <h3 class="panel-title">Members</h3>
            </div>
            <div class="panel-body no-padding emp-list" id="members-'.$question['id'].'">

            </div>
            <div class="panel-footer text-center">
              <!-- <a href="javascript:void(0)" class="uppercase">View All Members</a> -->
            </div>
            <!-- /.box-footer -->
          </div>
          <!--/.box -->
        </div>
        <div id="answers-'.$question['id'].'" class="special_question col-md-7">
        </div>
        </div>
        </div>
        </div>
        </div>
            ';

            return $results;
  }

  private function textarea_question($question)
  {
    $results = '<div class="col-md-12" style="margin-bottom:10px;">
          <div class="form-group-lg">
            <label class="col-md-12 control-label"><strong> - '.$question['question'].'</strong></label>
            <div class="col-md-12">
              ';
    $count = 0;
    $answers_l = (is_array($question['answer']))? $question['answer'] : json_decode($question['answer']);
      foreach($answers_l AS $answer){
        // $a = explode('-',$answer);
        $value = (isset($question['answers'][0]['answer_value']))? json_decode($question['answers'][0]['answer_value'])[0] : '';
        $results .= '
          <textarea class="form-control" rows="5" name="question_'.$question['id'].'[]" id="question_'.$question['id'].'_'.$count.'">'.$value.'</textarea>
        ';
      }
      $results .= '</div>
                </div>
              </div>';
      return $results;
  }

  private function child_special_question($question)
  {
    $results = '
    <div class="panel box box-danger">
      <div class="box-header with-border">
        <h4 class="box-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="collapsed" aria-expanded="false">
            nalqubali | GPO | Building Alfa
          </a>
        </h4>
        <div class="box-tools pull-right">

          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
          </button>
        </div>
      </div>
      <div id="collapseTwo" class="panel-collapse collapse" aria-expanded="false">
        <div class="box-body">
          <ul class="nav nav-tabs" id="myTabs">
            <li role="presentation" class="active"><a data-toggle="tab" href="#home">Team work</a></li>
            <li role="presentation"><a data-toggle="tab" href="#menu1">Communication</a></li>
          </ul>

          <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
              <div class="col-md-12">

                <form role="form" class="">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Affecting Energy:</label>
                      <p></p>
                      <input id="ex1" class="form-control ex1" data-slider-id= type="text" data-slider-min="0" data-slider-max="20" data-slider-step="1" data-slider-value="14"/>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Talk Often</label>
                      <div class="form-group">
                        <div class="radio-inline">
                          <label>
                            <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked="">
                            Option one
                          </label>
                        </div>
                        <div class="radio-inline">
                          <label>
                            <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                            Option two
                          </label>
                        </div>
                        <div class="radio-inline">
                          <label>
                            <input type="radio" name="optionsRadios" id="optionsRadios3" value="option3" >
                            Option three
                          </label>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="exampleInputPassword1">Long You know</label>
                      <div class="form-group">
                        <div class="radio-inline">
                          <label>
                            <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked="">
                            Option one
                          </label>
                        </div>
                        <div class="radio-inline">
                          <label>
                            <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                            Option two
                          </label>
                        </div>
                        <div class="radio-inline">
                          <label>
                            <input type="radio" name="optionsRadios" id="optionsRadios3" value="option3" >
                            Option three
                          </label>
                        </div>
                      </div>
                    </div>


                    <div class="form-group">
                      <label for="exampleInputPassword1">Understands ...</label>
                      <div class="form-group">
                        <div class="checkbox-inline">
                          <label>
                            <input type="checkbox" name="optionsRadios" id="optionsRadios1" value="option1" checked="">
                            Option one
                          </label>
                        </div>
                        <div class="checkbox-inline">
                          <label>
                            <input type="checkbox" name="optionsRadios" id="optionsRadios2" value="option2">
                            Option two
                          </label>
                        </div>
                        <div class="checkbox-inline">
                          <label>
                            <input type="checkbox" name="optionsRadios" id="optionsRadios3" value="option3" >
                            Option three
                          </label>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="exampleInputPassword1">Understands ...</label>
                      <div class="form-group">
                        <div class="checkbox-inline">
                          <label>
                            <input type="checkbox" name="optionsRadios" id="optionsRadios1" value="option1" checked="">
                            Option one
                          </label>
                        </div>
                        <div class="checkbox-inline">
                          <label>
                            <input type="checkbox" name="optionsRadios" id="optionsRadios2" value="option2">
                            Option two
                          </label>
                        </div>
                        <div class="checkbox-inline">
                          <label>
                            <input type="checkbox" name="optionsRadios" id="optionsRadios3" value="option3" >
                            Option three
                          </label>
                        </div>
                      </div>
                    </div>


                  </div>
                  <!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                  </div>
                </form>
              </div>
            </div>
            <div id="menu1" class="tab-pane fade">
              <div class="col-md-12">

                <form role="form" class="">
                  <div class="box-body">

                    <div class="form-group">
                      <label for="exampleInputPassword1">Turn for input?</label>
                      <div class="form-group">
                        <div class="radio-inline">
                          <label>
                            <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked="">
                            Yes
                          </label>
                        </div>
                        <div class="radio-inline">
                          <label>
                            <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                            No
                          </label>
                        </div>

                      </div>
                    </div>

                    <div class="form-group">
                      <label for="exampleInputPassword1">Communication with?</label>
                      <div class="form-group">
                        <div class="radio-inline">
                          <label>
                            <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked="">
                            Yes
                          </label>
                        </div>
                        <div class="radio-inline">
                          <label>
                            <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                            No
                          </label>
                        </div>

                      </div>
                    </div>

                    <div class="form-group">
                      <label for="exampleInputEmail1">Influential:</label>
                      <p></p>
                      <input id="ex1" class="form-control ex1" data-slider-id= type="text" data-slider-min="0" data-slider-max="20" data-slider-step="1" data-slider-value="14"/>
                    </div>

                    <div class="form-group inline" style="padding-right:40px;">
                      <label for="exampleInputPassword1">Aspect 1</label>
                      <div class="form-group inline">

                      <div id="stars-existing" class="starrr" data-rating=></div>
                    </div>
                  </div>

                    <div class="form-group inline">
                      <label for="exampleInputPassword1">Aspect 2</label>
                      <div class="form-group inline">


    ';
  }

  public function getEmployeeDirectory(Request $request){
    $e = Employee::select('name', 'department_id', 'project_id', 'building_id')->where('company_id', $this->user->company_id)->with('department')->with('project')->with('building')->with('skills')->orderBy('department_id')->orderBy('building_id')->get();
    $e = $e->toArray();
    $results = [];
    $group_by = '';
    $building = '';
    $loop_group_counter = -1;

    foreach($e AS $row){
      if(empty($row['building']['name'])){ $row['building']['name'] = 'N/A';}
      if(empty($group_by) || $group_by != $row['department']['name']){
        $group_by = $row['department']['name'];
        ++$loop_group_counter;
        $building_loop = -1;
        $results[$loop_group_counter] = ['text' => $group_by, 'id' => 'dep-'.$row['department']['id'], 'icon' => 'fa fa-fw fa-users', 'selectable' => false, 'state' => ['checked' => false], 'nodes' => array()];
      }
      if(empty($building) || $building != $row['building']['name'] || $building_loop == -1){
        $building = $row['building']['name'];
        ++$building_loop;
        if(!isset($results[$loop_group_counter]['nodes'][$building_loop])){
          $results[$loop_group_counter]['nodes'][$building_loop] = ['text' => $building, 'id' => $row['department']['id'].'-'.$row['building']['id'], 'icon' => 'fa fa-fw fa-building', 'nodes' => array()];
        }
      }
      // $tmp = ['text' => $row['name'].' | '. $row['department']['name'] . '  |  '. $row['building']['name'], 'selectable' => true, 'icon' => 'fa fa-fw fa-user',  'state' => ['checked' => false],];
      // array_push($results[$loop_group_counter]['nodes'], $tmp);
      // array_push($results[$loop_group_counter]['nodes'][$building_loop]['nodes'], $tmp);


    }
    // return response()->json($results, 200, $headers);
    echo json_encode($results);
  }

  public function getEmployeeList(Request $request){

    $list_ids = ($request->input('list_id'))? explode('-', $request->input('list_id')) : null;
    $question_id = ($request->input('question_id'))? $request->input('question_id') : '0';
    if(!is_null($list_ids)){
        $e = Employee::select('id', 'name', 'department_id', 'project_id', 'building_id')->where('company_id', $this->user->company_id)->where('department_id', $list_ids[0])->where('building_id', $list_ids[1])->with('department')->with('project')->with('building')->with('skills')->orderBy('department_id')->orderBy('building_id')->get();
    } else{
        $e = Employee::select('id', 'name', 'department_id', 'project_id', 'building_id')->where('company_id', $this->user->company_id)->with('department')->with('project')->with('building')->with('skills')->orderBy('department_id')->orderBy('building_id')->get();
    }


    $e = $e->toArray();
    $results = '<ul class="users-list clearfix">';

    foreach($e AS $row){
      $results .= '<li class="col-md-4">
        <img src="/vendor/adminlte/dist/img/default-50x50.gif"  alt="User Image">
        <a class="users-list-name" id="emp-'.$row['id'].'" href="" onclick="selectEmp('.$row['id'].','.$question_id.', event);">'.$row['name'].'</a>
        <!-- <span class="users-list-date">Today</span> -->
      </li>';
    }
    $results .= '</ul>';
    // return response()->json($results, 200, $headers);
    echo $results;
  }


  public function getQuestionPanel(Request $request)
  {
    $emp_id = ($request->input('emp_id')) ? $request->input('emp_id') : die(0);
    $this->data['question_id'] = ($request->input('question_id'))? $request->input('question_id') : die(0);
    $this->data['emp'] = Employee::where('id', $emp_id)->first()->toArray();
    //the next two variables, have to combine them. Check performance.
    $parent_question = Question::where('id',$this->data['question_id'])->with('children')->first()->toArray();
    $question_section_ids = Question::where('parent_id', $this->data['question_id'])->with('question_section')->get()->pluck('question_section')->pluck('id')->toArray();
    $this->data['question_sections'] = Question_section::whereIn('id', $question_section_ids)->get();


    return view('landing.ajax.question-panel', $this->data);

  }



  public function getQuestionlist(Request $request)
  {
    $this->data['question_id'] = ($request->input('question_id'))? $request->input('question_id') : die(0);
    $question_section_id = ($request->input('section_id'))? $request->input('section_id') : die(0);
    // $sections = Question_section::where('parent_id', $question_section_id)->get();
    // $questions = Question::
    //   whereHas('question_section', function ($query) use( $question_section_id) {
    //     $query->where('parent_id', $question_section_id);
    //   })->with(array('answers' => function($query) {
    //     $query->where('user_id', $this->user->id);
    //   }))->
    //   orderBy('question_section_id', 'ASC')->with('question_section')->get()->toArray();

    $questions = Question::where('parent_id', $this->data['question_id'])->with('question_section')->get();

      $questions = Question_section::whereHas('questions', function($query) {
        $query->with(['answers' => function($query) {
          $query->whereIn('questions', $questions->pluck('id'))->where('user_id', $this->user->id);
        }]);
      })->with(['questions' => function($query) {
          $query->where('parent_id', $this->data['question_id']);
      }])->with(['questions.answers' => function($query) {
          $query->where('user_id', $this->user->id);
      }])->get()->toArray();




      //dd($answered_questions);


      $this->data['results'] = '<div class="row"><div class="panel-group" id="questions" role="tablist" aria-multiselectable="true">';
      $result_arr = [];
      foreach ($questions as $section) {
        $answered_questions_section = Answer::where('user_id', $this->user->id)->whereHas('question', function($query) use($section){
          $query->where('question_section_id',$section['id']);
        })->count();
        $this->data['results'] .= '<div class="col-md-12 flip" style="margin-bottom:10px;">
        <div class="panel panel-info">
          <div class="panel-heading" role="tab" id="heading-'.$section['id'].'">
          <div class="panel-title">
            <h4>
              <a class="collapsed" role="button" data-toggle="collapse" data-parent="#questions" href="#collapse-'.$section['id'].'" aria-expanded="false" aria-controls="collapse-'.$section['id'].'">
                '.$section['name'].'
              </a>
              <span class="label label-default pull-left">
                <span class="label label-success pull-left">'.$answered_questions_section.'</span><span class="label label-info pull-left">'.count($section['questions']).'</span>
              </span>
            </h4>
          </div>
        </div>
        <div id="collapse-'.$section['id'].'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-'.$section['id'].'">
        <div class="panel-body"><form class="form-horizontal" role="form" id="section-form-'.$section['id'].'">';
        foreach($section['questions'] AS $question){
          $this->data['results'] .= '<div class="row">';
          switch ($question['question_type_id']) {
            //multiple radio
            case '1':
              $this->data['results'] .= $this->radio_question($question);
              break;

              //multiple checkbox
              case '2':
                $this->data['results'] .= $this->checkbox_question($question);
              break;
              //slider Number
              case '3':
                $this->data['results'] .= $this->slider_question($question);
              break;
              //slider rating
              case '4':
                $this->data['results'] .= $this->rating_question($question);
              break;

              //special question parent
              case '5':
                $this->data['results'] .= $this->special_question($question);
              break;
              //special question child
              // case '6':
              //
              // break;

              //case 7 and default textarea
              default:
                $this->data['results'] .= $this->textarea_question($question);
              break;
          }
          $this->data['results'] .= '
              </div>
            ';
        }
        $this->data['results'] .= '
        <div class="form-group" style="margin-top:20px;">
           <div class="col-md-8 col-md-offset-2">
              <input type="hidden" name="section_id" value="'.$question_section_id.'" />
             <button type="button" class="btn btn-success col-md-12" onclick="saveSection('.$section['id'].')">Save</button>
           </div>
          </div>
            </form></div></div></div></div>';
      }
      $this->data['results'] .= '</div></div></div>';

    // dd($questions);
    return $this->data['results'];
  }


  public function submitSurvey(Request $request)
  {
    $start = Answer::where('user_id', $this->user->id)->where('survey_id' , $this->data['selected_survey']->id)->orderBy('created_at', 'ASC')->first();

    $add = Submitted_survey::create(['survey_id' => $this->data['selected_survey']->id, 'user_id' => $this->user->id, 'start' => $start->created_at->format('Y-m-d H:i:s'), 'end' => date("Y-m-d H:i:s")]);

    return 1;
  }



}
