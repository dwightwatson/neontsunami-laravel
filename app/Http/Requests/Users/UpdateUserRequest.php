<?php

namespace App\Http\Requests\Users;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = $this->route()->parameter('user');

        return [
            'email' => ['email', Rule::unique('users')->ignore($user->getKey())]
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

        $user = $this->route()->parameter('user');

        return $url->route('admin.users.edit', $user);
    }
}
