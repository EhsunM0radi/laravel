<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use App\Models\ProjectUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $projectsUserCreate = Project::where('creator', $user->id)->get();
            $projectsUserCollaborate = ProjectUser::where('user_id', $user->id)->get();

            return view('tasks.index', ['tasks' => Task::all(), 'user' => $user, 'projectsUserCreate' => $projectsUserCreate, 'projectsUserCollaborate' => $projectsUserCollaborate]);
        } else {
            // User is not authenticated, redirect to the login page
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
            return view('tasks.create', ['tasks' => Task::all(), 'projects' => Project::all(), 'user' => Auth::user()]);
        } else {
            // User is not authenticated, redirect to the login page
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
            'project_id' => 'required',
            'estimate' => 'required'
        ]);
        $task = new Task([
            'title' => $request->input('title'),
            'creator' => $request->input('creator'),
            'description' => $request->input('description'),
            'project_id' => $request->input('project_id'),
            'estimate' => $request->input('estimate')
        ]);
        $task->save();
        return redirect()->route('tasks.index')->with('success', 'task created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        if (Auth::check()) {
            return view('tasks.show', ['task' => $task, 'projects' => Project::all()]);
        } else {
            // User is not authenticated, redirect to the login page
            return redirect()->route('login');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        if (Auth::check()) {
            return view('tasks.edit', ['task' => $task, 'projects' => Project::all(), 'user' => Auth::user()]);
        } else {
            // User is not authenticated, redirect to the login page
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
    public function update(Task $task, Request $request)
    {
        $this->authorize('update', $task);

        if (Auth::check()) {
            $incomingFields = $request->validate([
                'title' => 'required|string|max:255',
                'creator' => 'required',
                'description' => 'required|string',
                'project_id' => 'required'
            ]);
            if (!$request->isMethod('put')) {
                // Handle invalid request method (optional)
                return redirect()->route('tasks.index')->with('error', 'Invalid request method.');
            }

            $incomingFields['title'] = strip_tags($incomingFields['title']);
            $incomingFields['creator'] = strip_tags($incomingFields['creator']);
            $incomingFields['description'] = strip_tags($incomingFields['description']);
            $incomingFields['project_id'] = strip_tags($incomingFields['project_id']);

            $task->update($incomingFields);

            return redirect()->route('tasks.show', ['task' => $task])->with('success', 'task updated successfully.');
        } else {
            // User is not authenticated, redirect to the login page
            return redirect()->route('login');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $this->authorize('destroy', $task);
        if (Auth::check()) {
            $task->delete();

            // Redirect to a specified route
            return redirect()->route('tasks.index')->with('success', 'Project deleted successfully.');
        } else {
            // User is not authenticated, redirect to the login page
            return redirect()->route('login');
        }
    }
    public function chooseProject(Request $request)
    {
        // Validate that the request has a selected project
        $request->validate([
            'selected' => 'required'
        ]);

        // Get the JSON response of the selected project
        $response = $request->input('selected')['jsonResponse'];

        // Check if the response is empty or invalid
        // if (empty($response) || !is_array($response)) {
        //     // Abort with a 404 error
        //     abort(404, 'Invalid project response');
        // }

        // Return the response
        return response()->json($response);
    }
}
