<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EmployeeRequest extends \Backpack\CRUD\app\Http\Requests\CrudRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:255',
            'department_id' => 'required|integer',
            'building_id' => 'required|integer',
            'project_id' => 'integer|nullable',
            'gender' => 'string|nullable',
            'value_system' => 'string|nullable',
            'csi' => 'string|nullable',
            'skills' => 'string|nullable'
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
