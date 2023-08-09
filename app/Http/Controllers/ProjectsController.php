<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            return view('projects.index', ['projects' => Project::all(), 'user' => Auth::user()]);
        } else {
            return redirect()->route('login');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::check()) {
            return view('projects.create', ['projects' => Project::all(), 'user' => Auth::user()]);
        } else {
            return redirect()->route('login');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (Auth::check()) {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'creator' => 'required',
            ]);
            $project = new Project([
                'title' => $request->input('title'),
                'creator' => $request->input('creator'),
                'description' => $request->input('description'),
            ]);
            $project->save();
            return redirect()->route('projects.index')->with('success', 'Project created successfully.');
        } else {
            return redirect()->route('login');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        if (Auth::check()) {
            if (!$project) {
                return redirect()->route('projects.index')->with('error', 'Project not found.');
            }

            return view('projects.show', ['project' => $project]);
        } else {
            return redirect()->route('login');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        if (Auth::check()) {
            if (!$project) {
                return redirect()->route('projects.index')->with('error', 'Project not found.');
            }
            return view('projects.edit', ['project' => $project, 'user' => Auth::user()]);
        } else {
            return redirect()->route('login');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Project $project, Request $request)
    {
        $this->authorize('update', $project);

        if (Auth::check()) {
            $incomingFields = $request->validate([
                'title' => 'required|string|max:255',
                'creator' => 'required',
                'description' => 'required|string',
            ]);
            if (!$request->isMethod('put')) {
                // Handle invalid request method (optional)
                return redirect()->route('projects.index')->with('error', 'Invalid request method.');
            }

            $incomingFields['title'] = strip_tags($incomingFields['title']);
            $incomingFields['creator'] = strip_tags($incomingFields['creator']);
            $incomingFields['description'] = strip_tags($incomingFields['description']);

            $project->update($incomingFields);

            return redirect()->route('projects.show', ['project' => $project])->with('success', 'Project updated successfully.');
        } else {
            return redirect()->route('login');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $this->authorize('destroy', $project);

        if (Auth::check()) {
            $project->delete();

            // Redirect to a specified route
            return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
        } else {
            // User is not authenticated, redirect to the login page
            return redirect()->route('login');
        }
    }
}
