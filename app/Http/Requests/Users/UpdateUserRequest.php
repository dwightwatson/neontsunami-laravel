<?php

namespace NeonTsunami\Http\Requests\Users;

use NeonTsunami\Http\Requests\Request;

class UpdateUserRequest extends Request
{
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
        $user = $this->route()->parameter('users');

        return [
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => ['required', 'email', 'unique:users,email,'.$user->getKey()],
            'password'   => 'required'
        ];
    }

    /**
     * Get the URL to redirect to on a validation error.
     *
     * @return string
     */
    protected function getRedirectUrl()
    {
        $url = $this->redirector->getUrlGenerator();

        $user = $this->route()->parameter('users');

        return $url->route('admin.users.edit', $user);
    }
}
