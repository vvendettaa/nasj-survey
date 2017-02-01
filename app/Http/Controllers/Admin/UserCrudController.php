<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\UserRequest as StoreRequest;
use App\Http\Requests\UserRequest as UpdateRequest;
use App\Http\Controllers\Controller;


class UserCrudController extends CrudController
{


    public function setUp()
    {

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
        $this->crud->setModel("App\Models\User");
        $this->crud->setRoute("admin/user");
        $this->crud->setEntityNameStrings('user', 'users');

        $this->crud->enableAjaxTable();

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/

        $this->crud->setFromDb();

        $this->crud->setColumns(['name', 'email'], 'update/create/both');
        $this->crud->addField([
      	'name' => 'name',
      	'label' => "Name"
      	]);


        // $this->crud->setColumns(['email']);
        $this->crud->addField([
          'name' => 'email',
          'label' => 'Email Address',
          'type' => 'email'
        ]);

        $this->crud->removeField('password', 'update/create/both');
        if(\Ntrust::hasRole('super_admin')){
          // $this->crud->setColumns(['password']);
          $this->crud->addField([
            'name' => 'password',
            'label' => 'Password',
            'type' => 'password'
          ]);
        }

        $this->crud->addColumn(
          [
           // n-n relationship (with pivot table)
           'label' => "Roles", // Table column heading
           'type' => "select_multiple",
           'name' => 'roles', // the method that defines the relationship in your Model
           'entity' => 'roles', // the method that defines the relationship in your Model
           'attribute' => "display_name", // foreign key attribute that is shown to user
           'model' => "App\Models\Role", // foreign key model
        ]
        );

        $this->crud->addField([
          'label' => "Role",
          'type' => 'select2_user_custom',
          'name' => 'roles', // the method that defines the relationship in your Model
          'entity' => 'roles', // the method that defines the relationship in your Model
          'attribute' => 'display_name', // foreign key attribute that is shown to user
          'model' => "App\Models\Role", // foreign key model
          'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
          'foreign_pivot_key' => 'role_id'
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
		// your additional operations before save here

        if(empty($request->input('password'))){
          $request->request->set('password', $this->randomPassword());
        }
        $request->request->set('password', bcrypt($request->input('password')));

        $request->request->set('roles', [$request->input('roles')]);

        //TODO:: SET VALIDATION in Request Validate Roles if the creator have the permission

        $redirect_location = parent::storeCrud($request);

        //TODO:: Send email to user email.

        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
	}

	public function update(UpdateRequest $request)
	{
		// your additional operations before save here
    if(empty($request->input('password'))){
      $request->request->set('password', $this->randomPassword());
    }
    $request->request->set('password', bcrypt($request->input('password')));

    //TODO:: Validate Roles if the creator have the permission

        $redirect_location = parent::updateCrud($request);

        //TODO:: Send email to user email.

        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
	}

  private function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}
}
