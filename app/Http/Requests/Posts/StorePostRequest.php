<?php

namespace App\Http\Requests\Posts;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class StorePostRequest extends Request
{
    /**
     * The route to redirect to if validation fails.
     *
     * @var string
     */
    protected $redirectRoute = 'admin.posts.create';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'series_id' => ['nullable', Rule::exists('series', 'id')],
            'title' => 'required',
            'slug' => ['required', Rule::unique('posts')],
            'content' => 'required'
        ];
    }
}
