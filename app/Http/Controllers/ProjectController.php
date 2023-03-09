<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

class ProjectController extends Controller
{
    public function index(): Response
    {
        $projects = auth()->user()->accessibleProjects;

        return response()->view('projects.index',compact('projects'));
    }


    public function show(Project $project): Response
    {
        $this->authorize('update', $project);

        return response()->view('projects.show', compact('project'));
    }


    public function create()
    {
        return response()->view('projects.create');

    }

    public function store(): RedirectResponse
    {
        $project = auth()->user()->projects()->create($this->validateRequest());

        return redirect($project->path());
    }

    public function edit(Project $project): Response
    {       //don't know why this solves the error

        return response()->view('projects.edit',compact('project'));

/*        return view('projects.edit', compact('project'));*/
    }


    public function update(Project $project): RedirectResponse
    {
        $this->authorize('update', $project);

        $project->update($this->validateRequest());

        return redirect($project->path());
    }

public function destroy(Project $project): Redirector|Application|RedirectResponse
{
    $this->authorize('manage', $project);

    $project->delete();
        return redirect('/projects');
}
    protected function validateRequest() :array
    {
        return request()->validate([
            'title' => 'sometimes|required',
            'description' => 'sometimes|required',
            'notes' => 'nullable'
        ]);

}

}
