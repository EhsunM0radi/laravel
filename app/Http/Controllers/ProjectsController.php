<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Models\ProjectUser;
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
        $roles = [
            'developer',
            'tester',
            'project manager'
        ];
        if (Auth::check()) {
            return view('projects.create', ['roles' => $roles, 'projects' => Project::all(), 'user' => Auth::user(), 'users' => User::all()]);
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
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'creator' => 'required',
            'users' => 'array',
        ]);
        $project = Project::create([
            'title' => $request->input('title'),
            'creator' => $request->input('creator'),
            'description' => $request->input('description')
        ]);
        $lastInsertedId = $project->id;
        $users = $request->input('users', []);

        foreach ($users as $key => $user) {
            $project_user = ProjectUser::create([
                'project_id' => $lastInsertedId,
                'user_id' => $user,
                'type' => $request->input('role' . strval($key))
            ]);
        }

        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
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

            return view('projects.show', ['project' => $project, 'users' => User::all(), 'projectUsers' => ProjectUser::where('project_id', $project->id)->get()]);
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
        $roles = [
            'developer',
            'tester',
            'project manager'
        ];
        if (!$project) {
            return redirect()->route('projects.index')->with('error', 'Project not found.');
        }
        return view('projects.edit', ['roles' => $roles, 'project' => $project, 'user' => Auth::user(), 'users' => User::all(), 'projectUsers' => ProjectUser::where('project_id', $project->id)->get()]);
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
                'users' => 'array'
            ]);
            if (!$request->isMethod('put')) {
                // Handle invalid request method (optional)
                return redirect()->route('projects.index')->with('error', 'Invalid request method.');
            }

            $incomingFields['title'] = strip_tags($incomingFields['title']);
            $incomingFields['creator'] = strip_tags($incomingFields['creator']);
            $incomingFields['description'] = strip_tags($incomingFields['description']);

            $project->update($incomingFields);

            $selectedUserIds = $request->input('users', []);

            // Delete existing project-user relationships for the project
            ProjectUser::where('project_id', $project->id)->delete();

            // Insert new project-user relationships based on selected users
            foreach ($selectedUserIds as $userId) {
                ProjectUser::create([
                    'project_id' => $project->id,
                    'user_id' => $userId,
                ]);
            }

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

    public function handleSelectedUsers(Request $request)
    {
        $selectedUserIds = $request->input('selectedUsers'); // Array of selected user IDs

        // Fetch user details based on selectedUserIds
        $selectedUsers = User::whereIn('id', $selectedUserIds)->get();

        // Return a JSON response with the selected users
        return response()->json(['selectedUsers' => $selectedUsers]);
    }
}
