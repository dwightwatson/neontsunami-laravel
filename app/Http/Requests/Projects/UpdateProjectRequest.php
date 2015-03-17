<?php namespace NeonTsunami\Http\Requests\Projects;

use NeonTsunami\Http\Requests\Request;

class UpdateProjectRequest extends Request {

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
        $project = $this->route()->parameter('projects');

		return [
			'name'        => 'required',
            'slug'        => ['required', 'unique:projects,slug,'.$project->getKey()],
            'description' => 'required',
            'url'         => 'url'
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

        $project = $this->route()->parameter('projects');

        return $url->route('admin.projects.edit', $project);
    }

}
