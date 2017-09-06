<?php

namespace App\Http\Requests\Series;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class StoreSeriesRequest extends Request
{
    /**
     * The route to redirect to if validation fails.
     *
     * @var string
     */
    protected $redirectRoute = 'admin.series.create';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'slug' => ['required', Rule::unique('series')],
            'description' => 'required'
        ];
    }
}
