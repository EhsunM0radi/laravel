<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('projects.index', ['projects' => Project::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('projects.create', ['projects' => Project::all()]);
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
            'creator' => 'required|string|max:255',
        ]);
        $project = new Project([
            'title' => $request->input('title'),
            'creator' => $request->input('creator'),
            'description' => $request->input('description'),
        ]);
        $project->save();
        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::find($id);

        if (!$project) {
            return redirect()->route('projects.index')->with('error', 'Project not found.');
        }

        return view('projects.show', ['id' => $id, 'project' => $project]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::find($id);
        if (!$project) {
            return redirect()->route('projects.index')->with('error', 'Project not found.');
        }
        return view('projects.edit', ['id' => $id, 'project' => $project]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        dd($request->all());

        $request->validate([
            'title' => 'required|string|max:255',
            'creator' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
        if (!$request->isMethod('put')) {
            // Handle invalid request method (optional)
            return redirect()->route('projects.index')->with('error', 'Invalid request method.');
        }
        $project = Project::findOrFail($id);

        $project->update($request->all());

        return 'fdsljfld';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
