<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Question AS Question;
use App\Models\Question_type AS Question_type;
use App\Models\Question_section AS Question_section;
use App\Models\Survey AS Survey;
use App\Models\User AS User;
use App\Models\Question_import AS Question_import;
use Illuminate\Support\Facades\Log;

class ImportQuestion implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $qi;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Question_import $qi)
    {
        $this->qi = $qi;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      $rows_fields = [
          "question_type", "question_category", "question_sub", "question", "skill_1",
          "skill_2", "skill_3", "gender", "value_system",
          "csi"
      ];
      //Log::info(print_r($this->di));
      Log::info('Importing question file: '.public_path($this->qi->name));
      // die(print_r(public_path($this->di->name)));

      \Excel::load(public_path($this->qi->name), function ($reader) {

          // reader methods
          // Getting all results
          $results = $reader->get();
          $results = $reader->toArray();
          //  foreach ($results[0] AS $k => $v) {
              //  echo '"' . $k . '", ';
          //  }
          // print_r($results);

          foreach ($results as $row) {

              // foreach ($row AS $k => $v) {
              //     if (!empty($v)) {
              //         $row[$k] = trim($v);
              //     }
              //
              // }

              //first we add the post, to get the id.
              // $post = Post::create(['post_title' => $row['product_name'], 'sku' => $row['product_code'], 'brand' => $row['brand']]);

              if(!empty($row['question_type']) && !empty($row['question_category']) && !empty($row['answers']) && !empty($row['question'])){

                //Question_type
                $question_type = Question_type::firstOrCreate(['name' => trim($row['question_type'])]);
                //Question_type end

                if(!empty($row['question_sub'])){
                    //Question_section parnet
                    $parent_section = Question_section::firstOrCreate(['survey_id' => $this->qi->survey_id, 'name' => trim($row['question_category']), 'parent_id' => '0']);
                    //Question_section parent end
                    //print_r($parent_section);

                    //Question_section
                    $question_section = Question_section::firstOrCreate(['survey_id' => $this->qi->survey_id, 'name' => trim($row['question_sub']), 'parent_id' => $parent_section->id]);
                    //Question_section end
                } else{
                  //Question_section parnet
                  $parent_section = Question_section::firstOrCreate(['survey_id' => $this->qi->survey_id, 'name' => trim($row['question_category']), 'parent_id' => '0']);
                  //Question_section parent end
                  // print_r($parent_section);

                  //Question_section
                  $question_section = Question_section::firstOrCreate(['survey_id' => $this->qi->survey_id, 'name' => trim($row['question_category']), 'parent_id' => $parent_section->id]);
                  //Question_section end

                }

                //Answer
                $answer = json_encode(array_filter(explode(',', trim($row['answers']))));
                //Answer end

                //special question type
                $special_question_type = Question_type::firstOrCreate(['name' => trim($row['special_question_type'])]);
                //special question type end

                //parent question
                // $skill3 = Skill::firstOrCreate(['company_id' => 1, 'name' => trim($row['skill_3'])]);
                //parent question

                //Question
                $question = Question::firstOrCreate(['survey_id' => $this->qi->survey_id, 'question_section_id' => $question_section->id, 'question_type_id' => $question_type->id, 'question' => trim($row['question']), 'answer' => $answer]);
                //Question end

                Log::info('question ID: '.$question->id.' has been created.');
              } else{
                Log::info('One row has been skipped.');
              }

              // //skill
              // $concerns = explode(', ', $row['skill_!']);
              // foreach ($concerns AS $c) {
              //     $concern = WpTerm::firstOrCreate(['name' => $c]);
              //     //saved in wp_terms table
              //     if (!$concern->termTaxonomy()->exists()) {
              //         $concern_tax = $concern->termTaxonomy()->create(['taxonomy' => 'post_tag', 'description' => '']);
              //     } else {
              //         $concern_tax = $concern->termTaxonomy()->first();
              //     }
              //     $post->termTaxonomy()->save($concern_tax);
              // }
              // //concern end
              //brand





          }


  //            echo '<pre>';
  //            echo count($reader->toArray()[0]);
  //            die(print_r($reader->toArray()));
  //            dd($reader->toArray());

      });

      $this->qi->imported = true;
      $this->qi->save();
      Log::info('Importing question finished file: '.public_path($this->qi->name));
      return 1;
    }
}
