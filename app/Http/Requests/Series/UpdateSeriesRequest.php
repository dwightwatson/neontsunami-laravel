<?php

namespace App\Http\Requests\Series;

use App\Http\Requests\Request;

class UpdateSeriesRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $series = $this->route()->parameter('series');

        return [
            'slug' => ['unique:series,slug,'.$series->getKey()],
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

        $series = $this->route()->parameter('series');

        return $url->route('admin.series.edit', $series);
    }
}
