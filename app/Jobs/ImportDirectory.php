<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Building AS Building;
use App\Models\Department AS Department;
use App\Models\Employee AS Employee;
use App\Models\Project AS Project;
use App\Models\Skill AS Skill;
use App\Models\Directory_import AS Directory_import;
use Illuminate\Support\Facades\Log;

class ImportDirectory implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $di;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Directory_import $di)
    {
        $this->di = $di;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      $rows_fields = [
          "member", "department", "building", "project", "skill_1",
          "skill_2", "skill_3", "gender", "value_system",
          "csi"
      ];
      //Log::info(print_r($this->di));
      Log::info('Showing user profile for user: '.public_path($this->di->name));
      // die(print_r(public_path($this->di->name)));

      \Excel::load(public_path($this->di->name), function ($reader) {

          // reader methods
          // Getting all results
          $results = $reader->get();
          $results = $reader->toArray();
           foreach ($results[0] AS $k => $v) {
               echo '"' . $k . '", ';
           }
          print_r($results);
          return 1;
          foreach ($results as $row) {

              // foreach ($row AS $k => $v) {
              //     if (!empty($v)) {
              //         $row[$k] = trim($v);
              //     }
              //
              // }

              //first we add the post, to get the id.
              // $post = Post::create(['post_title' => $row['product_name'], 'sku' => $row['product_code'], 'brand' => $row['brand']]);

              //Department
              $department = Department::firstOrCreate(['company_id' => 1, 'name' => trim($row['department'])]);
              //Department end

              //Building
              $building = Building::firstOrCreate(['company_id' => 1, 'name' => trim($row['building'])]);
              //Building end

              //Project
              $project = Project::firstOrCreate(['company_id' => 1, 'name' => trim($row['project'])]);
              //Project end

              //Project
              $skill1 = Skill::firstOrCreate(['company_id' => 1, 'name' => trim($row['skill_1'])]);
              //Project end

              //Project
              $skill2 = Skill::firstOrCreate(['company_id' => 1, 'name' => trim($row['skill_2'])]);
              //Project end

              //Project
              $skill3 = Skill::firstOrCreate(['company_id' => 1, 'name' => trim($row['skill_3'])]);
              //Project end

              $e = new Employee();
              $e->company_id = 1;
              $e->name = trim($row['member']);
              $e->gender = trim($row['gender']);
              $e->value_system = trim($row['value_system']);
              $e->csi = trim($row['csi']);
              $e->department()->associate($department);
              $e->building()->associate($building);
              $e->project()->associate($project);
              $e->save();
              $e->skills()->attach($skill1);
              $e->skills()->attach($skill2);
              $e->skills()->attach($skill3);

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
    }
}
