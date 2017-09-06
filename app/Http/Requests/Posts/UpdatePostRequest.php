<?php

namespace App\Http\Requests\Posts;

use App\Http\Requests\Request;

class UpdatePostRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $post = $this->route()->parameter('post');

        return [
            'series_id' => 'nullable|exists:series,id',
            'slug'      => ['unique:posts,slug,'.$post->getKey()],
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

        $post = $this->route()->parameter('post');

        return $url->route('admin.posts.edit', $post);
    }
}
