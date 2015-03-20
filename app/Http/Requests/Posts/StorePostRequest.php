<?php namespace NeonTsunami\Http\Requests\Posts;

use NeonTsunami\Http\Requests\Request;

class StorePostRequest extends Request {

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
            'series_id' => 'exists:series,id',
            'title'     => 'required',
            'slug'      => ['required', 'unique:posts,slug'],
            'content'   => 'required'
		];
	}

}
