<?php

namespace App\Http\Requests\Projects;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class StoreProjectRequest extends Request
{
    /**
     * The route to redirect to if validation fails.
     *
     * @var string
     */
    protected $redirectRoute = 'admin.projects.create';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'        => 'required',
            'slug'        => ['required', Rule::unique('projects')],
            'description' => 'required',
            'url'         => 'url'
        ];
    }
}
