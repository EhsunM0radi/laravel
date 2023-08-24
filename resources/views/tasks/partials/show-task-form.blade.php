<div class="container mt-4">
    <h1>Task: {{ $task->title }}</h1>

    <form action="#">
        @csrf

        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" disabled class="form-control" name="title" id="title" value="{{ $task->title }}" required >
        </div>

        <div class="form-group">
            <label for="creator">Creator:</label>
            <input type="text" disabled class="form-control" name="creator" id="creator" value="{{ $task->_creator->name }}" required >
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" disabled name="description" id="description" rows="4" required>{{ $task->description }}</textarea>
        </div>

        <div class="form-group">
            <label for="project_id">Project Name:</label>
            <select class="form-control" disabled name="project_id" id="project_id" required>
                @foreach ($projects as $project)
                    <option value="{{ $project->id }}" {{ $task->project_id == $project->id ? 'selected' : '' }}>
                        {{ $project->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="parent">Parent:</label>
            <select class="form-control" name="parent" id="parent">
                <option value="" selected>Select a task</option>
                @foreach ($tasks as $_task)
                    <option value="{{ $_task->id }}" {{$task->id==$_task->id?'selected':''}}>{{ $_task->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="estimate">Estimate:</label>
            <input disabled type="number" value="{{$task->estimate}}" class="form-control" name="estimate" id="estimate" required>
        </div>

        <div class="form-group">
            <label for="status">Status:</label>
            <select disabled class="form-control" name="status" id="status">
                @foreach ($allStatus as $status)
                    <option value="{{ $status }}" {{$status==$task->status?'selected':'';}}>{{ $status }}</option>
                @endforeach
            </select>
        </div>


        <div class="form-group">
            <label for="requirements">Requirements:</label>
            <select disabled class="form-control js-example-basic-multiple" name="requirements[]" id="requirements" multiple='multiple'>
                @foreach ($tasks as $_task)
                    <option value="{{$_task->id}}">{{$_task->title}}</option>
                @endforeach
            </select>
        </div>

    </form>
</div>