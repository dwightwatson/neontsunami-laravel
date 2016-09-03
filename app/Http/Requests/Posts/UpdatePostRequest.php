<?php

namespace NeonTsunami\Http\Requests\Posts;

use NeonTsunami\Http\Requests\Request;

class UpdatePostRequest extends Request
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
        $post = $this->route()->parameter('post');

        return [
            'series_id'    => 'exists:series,id',
            'title'        => 'required',
            'slug'         => ['required', 'unique:posts,slug,'.$post->getKey()],
            'content'      => 'required'
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

        $post = $this->route()->parameter('posts');

        return $url->route('admin.posts.edit', $post);
    }
}
