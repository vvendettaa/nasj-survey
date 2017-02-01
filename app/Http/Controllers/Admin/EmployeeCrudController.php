<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\EmployeeRequest as StoreRequest;
use App\Http\Requests\EmployeeRequest as UpdateRequest;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Building;
use App\Models\Project;
use App\Models\Skill;


class EmployeeCrudController extends CrudController
{

    public function setUp()
    {

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
        $this->crud->setModel("App\Models\Employee");
        $this->crud->setRoute("admin/employee");
        $this->crud->setEntityNameStrings('employee', 'employees');

        $this->crud->enableAjaxTable();

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/

        $this->crud->setFromDb();

        $this->crud->removeColumns(['company_id', 'department_id', 'building_id', 'project_id']);
        $this->crud->removeField('company_id');

        //company

        if(\Ntrust::hasRole('super_admin')){
          // $this->crud->addColumn([
          //    // 1-n relationship
          //    'label' => "Company", // Table column heading
          //    'type' => "select",
          //    'name' => 'company_id', // the column that contains the ID of that connected entity;
          //    'entity' => 'company', // the method that defines the relationship in your Model
          //    'attribute' => "name", // foreign key attribute that is shown to user
          //    'model' => "App\Models\Company", // foreign key model
          // ]);
          //
          //   $this->crud->addField([  // Select2
          //    'label' => "Company",
          //    'type' => 'select2_custom',
          //    'name' => 'company_id', // the db column for the foreign key
          //    'entity' => 'company', // the method that defines the relationship in your Model
          //    'attribute' => 'name', // foreign key attribute that is shown to user
          //    'attributes' => [
          //      'id' => 'company_sel'
          //    ],
          //    'model' => "App\Models\Company" // foreign key model
          // ]);


        }

        //department

        $this->crud->addColumn([
           // 1-n relationship
           'label' => "Department", // Table column heading
           'type' => "select",
           'name' => 'department_id', // the column that contains the ID of that connected entity;
           'entity' => 'department', // the method that defines the relationship in your Model
           'attribute' => "name", // foreign key attribute that is shown to user
           'model' => "App\Models\Department", // foreign key model
        ]);

          $this->crud->addField([  // Select2
           'label' => "Department",
           'type' => 'select2_custom',
           'name' => 'department_id', // the db column for the foreign key
           'entity' => 'department', // the method that defines the relationship in your Model
           'attribute' => 'name', // foreign key attribute that is shown to user
           'attributes' => [
             'id' => 'department_sel'
           ],
           'model' => "App\Models\Department" // foreign key model
        ]);



        //building

        $this->crud->addColumn([
           // 1-n relationship
           'label' => "Building", // Table column heading
           'type' => "select",
           'name' => 'building_id', // the column that contains the ID of that connected entity;
           'entity' => 'building', // the method that defines the relationship in your Model
           'attribute' => "name", // foreign key attribute that is shown to user
           'model' => "App\Models\Building", // foreign key model
        ]);

                $this->crud->addField([  // Select2
           'label' => "Building",
           'type' => 'select2_custom',
           'name' => 'building_id', // the db column for the foreign key
           'entity' => 'building', // the method that defines the relationship in your Model
           'attribute' => 'name', // foreign key attribute that is shown to user
           'attributes' => [
             'id' => 'building_sel'
           ],
           'model' => "App\Models\Building" // foreign key model
        ]);

        //project

        $this->crud->addColumn([
           // 1-n relationship
           'label' => "Project", // Table column heading
           'type' => "select",
           'name' => 'project_id', // the column that contains the ID of that connected entity;
           'entity' => 'project', // the method that defines the relationship in your Model
           'attribute' => "name", // foreign key attribute that is shown to user
           'model' => "App\Models\Project", // foreign key model
        ]);

                $this->crud->addField([  // Select2
           'label' => "Project",
           'type' => 'select2_custom',
           'name' => 'project_id', // the db column for the foreign key
           'entity' => 'project', // the method that defines the relationship in your Model
           'attribute' => 'name', // foreign key attribute that is shown to user
           'attributes' => [
             'id' => 'project_sel'
           ],
           'model' => "App\Models\Project" // foreign key model
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
        $redirect_location = parent::storeCrud();
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

  public function view_test(){
    return view('employee-tree', $this->data);
  }

  public function get_employees(){
    $e = Employee::select('name', 'department_id', 'project_id', 'building_id')->with('department')->with('project')->with('building')->with('skills')->orderBy('department_id')->orderBy('building_id')->get();
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
        $results[$loop_group_counter] = ['text' => $group_by, 'icon' => 'fa fa-fw fa-users', 'selectable' => false, 'state' => ['checked' => false], 'nodes' => array()];
      }
      if(empty($building) || $building != $row['building']['name'] || $building_loop == -1){
        $building = $row['building']['name'];
        ++$building_loop;
        if(!isset($results[$loop_group_counter]['nodes'][$building_loop])){
          $results[$loop_group_counter]['nodes'][$building_loop] = ['text' => $building, 'icon' => 'fa fa-fw fa-building', 'nodes' => array()];
        }
      }
      $tmp = ['text' => $row['name'].' | '. $row['department']['name'] . '  |  '. $row['building']['name'], 'selectable' => true, 'icon' => 'fa fa-fw fa-user',  'state' => ['checked' => false],];
      // array_push($results[$loop_group_counter]['nodes'], $tmp);
      array_push($results[$loop_group_counter]['nodes'][$building_loop]['nodes'], $tmp);


    }
    // return response()->json($results, 200, $headers);
    echo json_encode($results);
  }
}
