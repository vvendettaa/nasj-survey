<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Question extends Model
{
    use CrudTrait;

     /*
	|--------------------------------------------------------------------------
	| GLOBAL VARIABLES
	|--------------------------------------------------------------------------
	*/

    protected $table = 'questions';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = ['id'];
    protected $fillable = ['survey_id', 'question_section_id', 'question_type_id', 'parent_id', 'question', 'answer'];
    protected $casts = [
        'answer' => 'json'
    ];
    // protected $hidden = [];
    // protected $dates = [];

    /*
	|--------------------------------------------------------------------------
	| FUNCTIONS
	|--------------------------------------------------------------------------
	*/
  public function survey()
    {
        return $this->belongsTo('App\Models\Survey');
    }

  public function question_section()
    {
        return $this->belongsTo('App\Models\Question_section');
    }

  public function question_type()
    {
        return $this->belongsTo('App\Models\Question_type');
    }

    //each question might have one parent
  public function parent() {
    return $this->hasOne(static::class, 'parent_id');
  }

  //each question might have multiple children
  public function children() {
    return $this->hasMany(static::class, 'parent_id');
  }

    /*
	|--------------------------------------------------------------------------
	| RELATIONS
	|--------------------------------------------------------------------------
	*/

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
