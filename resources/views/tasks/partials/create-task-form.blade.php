<div class="container mt-4">
    <h1>Create a New Task</h1>

    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control" name="title" id="title" required>
        </div>

            <input type="hidden" value="{{$user->id}}" class="form-control" name="creator" id="creator" required>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" name="description" id="description" rows="4" required></textarea>
        </div>

        {{-- <div class="form-group">
            <label for="project_id">Project Name:</label>
            <select class="form-control" name="project_id" id="project_id" required>
                <option value="" disabled selected>Select a project</option>
                @foreach ($projects as $project)
                    <option value="{{ $project->id }}">{{ $project->title }}</option>
                @endforeach
            </select>
        </div> --}}
        <input type="hidden" value=1 name="project_id">

        <div class="form-group">
            <label for="title">Parent:</label>
            <select class="form-control" name="parent" id="parent">
                <option value="" disabled selected>Select a task</option>
                @foreach ($tasks as $task)
                    <option value="{{ $project->id }}">{{ $project->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="estimate">Estimate:</label>
            <input type="number" class="form-control" name="estimate" id="estimate" required>
        </div>


        <button type="submit" class="btn btn-primary">Create Task</button>
    </form>
</div>