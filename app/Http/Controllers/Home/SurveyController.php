<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Survey;
use App\Models\Question;
use App\Models\Question_type;
use App\Models\Question_section;
use App\Models\Answer;

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

            $this->data['surveys'] = Survey::where('start_time', '<=', date('Y-m-d H:i:s'))->where('end_time', '>', date('Y-m-d H:i:s'))->get()->toArray();
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
    $request->session()->forget('selected_survey');

    return view('landing.home', $this->data);
  }

  public function getSurvey($slug){

        $this->data['selected_survey'] = Survey::where('slug', $slug)->first();
        session(['selected_survey' => $this->data['selected_survey']]);
        $this->data['question_sections'] = Question_section::
                              where('survey_id', $this->data['selected_survey']->id)
                              ->where('parent_id', '0')
                              ->get();
        $this->data['progress'] = (int)(Answer::where('user_id', $this->user->id)->where('survey_id', $this->data['selected_survey']->id)->count() / Question::where('survey_id', $this->data['selected_survey']->id)->count() * 100);


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

      $questions = Question_section::where('parent_id', $question_section_id)
      ->whereHas('questions', function($query) {
        $query->with(['answers' => function($query) {
          $query->where('user_id', $this->user->id);
        }]);
      })->with('questions')->with('questions.answers')->get()->toArray();




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
            case '1':
            $this->data['results'] .= '<div class="col-md-12" style="margin-bottom:10px;">
                  <div class="form-group-lg">
                    <label class="col-md-12 control-label"><strong> - '.$question['question'].'</strong></label>
                    <div class="col-md-12">
                      ';
            $count = 0;
              foreach(json_decode($question['answer']) AS $answer){
                $checked = (isset($question['answers'][0]['answer_value']) && $count == $question['answers'][0]['answer_value'])? 'checked="checked"' : '';
                $this->data['results'] .= '<div class="radio-inline"><label>
                  <input type="radio" name="question_'.$question['id'].'" id="optionsRadios1" value="'.$answer.','.$count++.'" '.$checked.'>
                  '.$answer.'
                </label></div>';
              }
              $this->data['results'] .= '</div>
                        </div>
                      </div>';
              break;

            default:
              # code...
              break;
          }
          $this->data['results'] .= '
              </div>
            ';
        }
        $this->data['results'] .= '
        <div class="form-group" style="margin-top:20px;">
           <div class="col-md-8 col-md-offset-2">
             <button type="button" class="btn btn-success col-md-12" onclick="saveSection('.$section['id'].', '.$question_section_id.')">Save</button>
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
      $v = explode(',',$value);
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
      $progress = (int)(Answer::where('user_id', $this->user->id)->where('survey_id', $this->data['selected_survey']->id)->count() / Question::where('survey_id', $this->data['selected_survey']->id)->count() * 100);

      $data = '<div class="progress-bar progress-bar-info" style="width: '.$progress.'%;"></div>
          <span class="" style="padding-right: 240px">Progress: '.$progress.'%</span>';
          return $data;
      }

  }



}
