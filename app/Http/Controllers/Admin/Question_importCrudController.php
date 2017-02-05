<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\Question_importRequest as StoreRequest;
use App\Http\Requests\Question_importRequest as UpdateRequest;

use App\Jobs\ImportQuestion;

class Question_importCrudController extends CrudController
{

    public function setUp()
    {

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
        $this->crud->setModel("App\Models\Question_import");
        $this->crud->setRoute("admin/question_import");
        $this->crud->setEntityNameStrings('Question Import', 'Question Imports');

        $this->crud->enableAjaxTable();

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/

        $this->crud->setFromDb();

        $this->crud->removeFields(['user_id', 'path', 'imported', 'survey_id']);
        $this->crud->removeColumns(['path', 'user_id', 'survey_id']);

        $this->crud->addField([   // Browse
            'name' => 'name',
            'label' => 'File',
            'type' => 'browse',
            'hint' => 'By adding an Excel file you will trigger the import. Please make sure that your file follow this <a href="' . url("public/employeeTemplate.xlsx") . '">template</a>'
        ]);

        $this->crud->addColumn([
        // 1-n relationship
        'label' => "User", // Table column heading
        'type' => "select",
        'name' => 'user_id', // the column that contains the ID of that connected entity;
        'entity' => 'user', // the method that defines the relationship in your Model
        'attribute' => "name", // foreign key attribute that is shown to user
        'model' => "App\Models\User", // foreign key model
        ]);

        $this->crud->addColumn([
          'label' => 'Imported',
          'type' => 'boolean',
          'name' => 'imported'
        ]);

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

        $request->request->set('user_id', \Auth::user()->id);
		// your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        dispatch(new ImportQuestion($this->crud->entry));
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
