<div class="container mt-4">
    <h1>Edit Task: {{ $task->title }}</h1>

    <form action="{{ route('tasks.update', ['task'=>$task]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control" name="title" id="title" value="{{ $task->title }}" required>
        </div>

            <input type="hidden" value="{{$user->id}}" class="form-control" name="creator" id="creator" value="{{ $task->creator }}" required>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" name="description" id="description" rows="4" required>{{ $task->description }}</textarea>
        </div>

        <div class="form-group">
            <label for="project_id">Project Name:</label>
            <select class="form-control" name="project_id" id="project_id" required>
                <option value="">Select an option</option>
                @foreach ($projects as $project)
                    <option value="{{ $project->id }}" {{ $task->project_id == $project->id ? 'selected' : '' }}>
                        {{ $project->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Task</button>
    </form>
</div>