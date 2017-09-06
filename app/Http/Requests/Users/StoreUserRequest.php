<?php

namespace App\Http\Requests\Users;

use App\Http\Requests\Request;

class StoreUserRequest extends Request
{
    /**
     * The route to redirect to if validation fails.
     *
     * @var string
     */
    protected $redirectRoute = 'admin.users.create';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (bool) $this->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'filled',
            'last_name'  => 'filled',
            'email'      => ['filled', 'email', 'unique:users,email'],
            'password'   => 'filled'
        ];
    }
}
