<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Question_section extends Model
{
    use CrudTrait;

     /*
	|--------------------------------------------------------------------------
	| GLOBAL VARIABLES
	|--------------------------------------------------------------------------
	*/

    protected $table = 'question_sections';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = ['id'];
    protected $fillable = ['survey_id', 'question_id', 'name', 'description', 'parent_id'];
    protected $attributes = ['question_id' => 0];
    // protected $hidden = [];
    // protected $dates = [];

    /*
	|--------------------------------------------------------------------------
	| FUNCTIONS
	|--------------------------------------------------------------------------
	*/

    /*
	|--------------------------------------------------------------------------
	| RELATIONS
	|--------------------------------------------------------------------------
	*/

    public function survey()
    {
        return $this->belongsTo('App\Models\Survey');
    }

    public function questions()
    {
        return $this->hasMany('App\Models\Question');
    }

    public function question()
    {
      return $this->belongsTo('App\Models\Question');
    }

    //each question might have one parent
    public function children() {
      return $this->hasMany(static::class, 'parent_id','id');
    }

    //each question might have multiple children
    public function parent() {
      return $this->belongsTo(static::class, 'parent_id','id');
    }


    /*
	|--------------------------------------------------------------------------
	| SCOPES
	|--------------------------------------------------------------------------
	*/

    /*
	|--------------------------------------------------------------------------
	| ACCESORS
	|--------------------------------------------------------------------------
	*/

    /*
	|--------------------------------------------------------------------------
	| MUTATORS
	|--------------------------------------------------------------------------
	*/
}
