<?php

namespace App\Http\Requests\Posts;

use App\Http\Requests\Request;

class StorePostRequest extends Request
{
    /**
     * The route to redirect to if validation fails.
     *
     * @var string
     */
    protected $redirectRoute = 'admin.posts.create';

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
            'series_id' => 'nullable|exists:series,id',
            'title'     => 'filled',
            'slug'      => ['filled', 'unique:posts,slug'],
            'content'   => 'filled'
        ];
    }
}
