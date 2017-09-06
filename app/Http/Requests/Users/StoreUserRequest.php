<?php

namespace App\Http\Requests\Users;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class StoreUserRequest extends Request
{
    /**
     * The route to redirect to if validation fails.
     *
     * @var string
     */
    protected $redirectRoute = 'admin.users.create';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => ['required', 'email', Rule::unique('users')],
            'password' => 'required'
        ];
    }
}
