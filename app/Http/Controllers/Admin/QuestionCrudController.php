<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\QuestionRequest as StoreRequest;
use App\Http\Requests\QuestionRequest as UpdateRequest;

class QuestionCrudController extends CrudController
{

    public function setUp()
    {
      //TODO:: Fix the entire logic of saving parent child relation.

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
        $this->crud->setModel("App\Models\Question");
        $this->crud->setRoute("admin/question");
        $this->crud->setEntityNameStrings('question', 'questions');

        $this->crud->enableAjaxTable();

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/

        $this->crud->setFromDb();
        $this->crud->removeColumns(['survey_id', 'parent_id', 'question_section_id', 'question_type_id', 'answer']);

        $this->crud->addColumn([
   // 1-n relationship
   'label' => "Survey", // Table column heading
   'type' => "select",
   'name' => 'survey_id', // the column that contains the ID of that connected entity;
   'entity' => 'survey', // the method that defines the relationship in your Model
   'attribute' => "name", // foreign key attribute that is shown to user
   'model' => "App\Models\Survey", // foreign key model
]);

        $this->crud->addField([  // Select2
   'label' => "Survey",
   'type' => 'select2_custom',
   'name' => 'survey_id', // the db column for the foreign key
   'entity' => 'survey', // the method that defines the relationship in your Model
   'attribute' => 'name', // foreign key attribute that is shown to user
   'attributes' => [
     'id' => 'survey_sel'
   ],
   'model' => "App\Models\Survey" // foreign key model
]);


$this->crud->addColumn([
// 1-n relationship
'label' => "Section", // Table column heading
'type' => "select",
'name' => 'question_section_id', // the column that contains the ID of that connected entity;
'entity' => 'question_section', // the method that defines the relationship in your Model
'attribute' => "name", // foreign key attribute that is shown to user
'model' => "App\Models\Question_section", // foreign key model
]);

$this->crud->addField([  // Select2
'label' => "Section",
'type' => 'select2_custom',
'name' => 'question_section_id', // the db column for the foreign key
'entity' => 'question_section', // the method that defines the relationship in your Model
'attribute' => 'name', // foreign key attribute that is shown to user
'attributes' => [
'id' => 'section_sel'
],
'model' => "App\Models\Question_section" // foreign key model
]);

$this->crud->addColumn([
// 1-n relationship
'label' => "Type", // Table column heading
'type' => "select",
'name' => 'question_type_id', // the column that contains the ID of that connected entity;
'entity' => 'question_type', // the method that defines the relationship in your Model
'attribute' => "name", // foreign key attribute that is shown to user
'model' => "App\Models\Question_type", // foreign key model
]);

$this->crud->addField([  // Select2
'label' => "Type",
'type' => 'select2_custom',
'name' => 'question_type_id', // the db column for the foreign key
'entity' => 'question_type', // the method that defines the relationship in your Model
'attribute' => 'name', // foreign key attribute that is shown to user
'attributes' => [
  'id' => 'type_sel'
],
'model' => "App\Models\Question_type" // foreign key model
]);


$this->crud->addColumn([
// 1-n relationship
'label' => "Parent", // Table column heading
'type' => "select",
'name' => 'parent_id', // the column that contains the ID of that connected entity;
'entity' => 'parent', // the method that defines the relationship in your Model
'attribute' => "question", // foreign key attribute that is shown to user
'model' => "App\Models\Question", // foreign key model
]);

$this->crud->addField([  // Select2
'label' => "Parent",
'type' => 'select2_custom',
'name' => 'parent_id', // the db column for the foreign key
'entity' => 'parent', // the method that defines the relationship in your Model
'attribute' => 'question', // foreign key attribute that is shown to user
'attributes' => [
  'id' => 'parent_sel'
],
'model' => "App\Models\Question", // foreign key model
'allow_empty' => true
]);
//TODO::Add where for only parent questions.


// $this->crud->addColumn([
//    'name' => 'question', // The db column name
//    'label' => "Question" // Table column heading
// ]);

$this->crud->addField([ // Text
    'name' => 'question',
    'label' => "Question",
    'type' => 'text',
]);


$this->crud->addField([  // Select2
'label' => "Type",
'type' => 'select2_custom',
'name' => 'question_special_type_id', // the db column for the foreign key
'entity' => 'question_type', // the method that defines the relationship in your Model
'attribute' => 'name', // foreign key attribute that is shown to user
'attributes' => [
  'id' => 'type2_sel'
],
'model' => "App\Models\Question_type" // foreign key model
]);
//TODO:: remove the last two options.

$this->crud->addColumn([
   'name' => 'answer', // The db column name
   'label' => "Answers", // Table column heading
   'type' => 'array'
]);


$this->crud->addField([
  'name' => 'answer',
  'label' => 'Answers',
  'type' => 'custom_answer',
  'attributes' => [
    'class' => 'custom_answer_field'
  ]
]);




        // ------ CRUD FIELDS
        // $this->crud->addField($options, 'update/create/both');
        // $this->crud->addFields($array_of_arrays, 'update/create/both');
        // $this->crud->removeField('name', 'update/create/both');
        // $this->crud->removeFields($array_of_names, 'update/create/both');

        // ------ CRUD COLUMNS
        // $this->crud->addColumn(); // add a single column, at the end of the stack
        // $this->crud->addColumns(); // add multiple columns, at the end of the stack
        // $this->crud->removeColumn('column_name'); // remove a column from the stack
        // $this->crud->removeColumns(['column_name_1', 'column_name_2']); // remove an array of columns from the stack
        // $this->crud->setColumnDetails('column_name', ['attribute' => 'value']); // adjusts the properties of the passed in column (by name)
        // $this->crud->setColumnsDetails(['column_1', 'column_2'], ['attribute' => 'value']);

        // ------ CRUD BUTTONS
        // possible positions: 'beginning' and 'end'; defaults to 'beginning' for the 'line' stack, 'end' for the others;
        // $this->crud->addButton($stack, $name, $type, $content, $position); // add a button; possible types are: view, model_function
        // $this->crud->addButtonFromModelFunction($stack, $name, $model_function_name, $position); // add a button whose HTML is returned by a method in the CRUD model
        // $this->crud->addButtonFromView($stack, $name, $view, $position); // add a button whose HTML is in a view placed at resources\views\vendor\backpack\crud\buttons
        // $this->crud->removeButton($name);
        // $this->crud->removeButtonFromStack($name, $stack);

        // ------ CRUD ACCESS
        // $this->crud->allowAccess(['list', 'create', 'update', 'reorder', 'delete']);
        // $this->crud->denyAccess(['list', 'create', 'update', 'reorder', 'delete']);

        // ------ CRUD REORDER
        // $this->crud->enableReorder('label_name', MAX_TREE_LEVEL);
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('reorder');

        // ------ CRUD DETAILS ROW
        // $this->crud->enableDetailsRow();
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('details_row');
        // NOTE: you also need to do overwrite the showDetailsRow($id) method in your EntityCrudController to show whatever you'd like in the details row OR overwrite the views/backpack/crud/details_row.blade.php

        // ------ REVISIONS
        // You also need to use \Venturecraft\Revisionable\RevisionableTrait;
        // Please check out: https://laravel-backpack.readme.io/docs/crud#revisions
        // $this->crud->allowAccess('revisions');

        // ------ AJAX TABLE VIEW
        // Please note the drawbacks of this though:
        // - 1-n and n-n columns are not searchable
        // - date and datetime columns won't be sortable anymore
        // $this->crud->enableAjaxTable();

        // ------ DATATABLE EXPORT BUTTONS
        // Show export to PDF, CSV, XLS and Print buttons on the table view.
        // Does not work well with AJAX datatables.
        // $this->crud->enableExportButtons();

        // ------ ADVANCED QUERIES
        // $this->crud->addClause('active');
        // $this->crud->addClause('type', 'car');
        // $this->crud->addClause('where', 'name', '==', 'car');
        // $this->crud->addClause('whereName', 'car');
        // $this->crud->addClause('whereHas', 'posts', function($query) {
        //     $query->activePosts();
        // });
        // $this->crud->with(); // eager load relationships
        // $this->crud->orderBy();
        // $this->crud->groupBy();
        // $this->crud->limit();
    }

	public function store(StoreRequest $request)
	{
        //dd(array_filter($request->input('answer')));
        $request->request->set('answer', json_encode(array_filter($request->input('answer'))));
        if(empty($request->input('parent_id')) || $request->input('question_type_id') != '6'){
            $request->request->set('parent_id', '0');
        }
		// your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
	}

	public function update(UpdateRequest $request)
	{
		// your additional operations before save here
        $redirect_location = parent::updateCrud();
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
	}
}
