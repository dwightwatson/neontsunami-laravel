<?php namespace NeonTsunami\Http\Requests\Series;

use NeonTsunami\Http\Requests\Request;

class StoreSeriesRequest extends Request {

    /**
     * The route to redirect to if validation fails.
     *
     * @var string
     */
    protected $redirectRoute = 'admin.series.create';

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
			'name'        => 'required',
            'slug'        => ['required', 'unique:series,slug'],
            'description' => 'required'
		];
	}

}
