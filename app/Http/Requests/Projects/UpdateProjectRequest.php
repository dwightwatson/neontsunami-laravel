<?php

namespace App\Http\Requests\Projects;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $project = $this->route()->parameter('project');

        return [
            'slug' => Rule::unique('projects', 'slug')->ignore($project->getKey()),
            'url'  => 'url'
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

        $project = $this->route()->parameter('project');

        return $url->route('admin.projects.edit', $project);
    }
}
