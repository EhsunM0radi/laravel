@extends('layouts.app')

@section('title','Tasks')

@section('content')

@if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="container">
      <a href="{{ route('tasks.create') }}" style="display: inline-block;"><h4>Add new Task +</h4></a><br>
      <span>
        <select class="js-example-basic-multiple" name="projectForUser">
          <option value="0">Choose a Project</option>
          @foreach ($projectsUserCreate as $projectUserCreate)
              <option value="{{$projectUserCreate->id}}">{{$projectUserCreate->title}}</option>
          @endforeach
          @foreach ($projectsUserCollaborate as $projectUserCollaborate)
              <option value="{{$projectUserCollaborate->project_id}}">{{$projectUserCollaborate->projectId->title}}</option>
          @endforeach
        </select>
      </span>
      <div class="card">
        <div class="card-header">{{ __('Tasks List') }}</div>
    
        <div class="card-body">
          <div class="table-responsive">
            <table id="my-table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Title</th>
                  <th>Creator</th>
                  <th>Description</th>
                  <th>Project title</th>
                  <th>Delete</th>
                  <th>Edit</th>
                  <th>View</th>
                </tr>
              </thead>
              <tbody>
                {{-- @foreach ($tasks as $task)
                  <tr>
                    <td>{{ $task->id }}</td>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->_creator->name }}</td>
                    <td>{{ $task->description }}</td>
                    <td>{{ $task->project->title }}</td>
                    <td>
                      <button {{$user->id==$task->creator?'':'disabled';}} type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{ $task->id }}" {{($user->id==$task->creator)?'':'disabled';}}>
                        Delete
                      </button>
                      <div class="modal fade" id="deleteModal{{ $task->id }}" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Delete Confirmation</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <p>Are you sure you want to delete?</p>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <form action="{{ route('tasks.destroy', ['task' => $task]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </td>
                    <td>
                      <form action="{{ route('tasks.edit', ['task' => $task]) }}" method="GET">
                        <button {{$user->id==$task->creator?'':'disabled';}} class="btn btn-dark" type="submit">Edit</button>
                      </form>
                    </td>
                    <td>
                      <form action="{{ route('tasks.show', ['task' => $task]) }}" method="GET">
                        <button class="btn btn-primary" type="submit">View</button>
                      </form>
                    </td>
                  </tr>
                @endforeach --}}
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <script>
      $(document).ready(function () {
        //initialize the datatables plugin on my table element
        var myTable = $('#my-table').dataTable({
  columns: [
    { title: 'ID', data: 'id' }, // use the id property of the task object
    { title: 'Title', data: 'title' }, // use the title property of the task object
    { title: 'Description', data: 'description' }
  ]
});
        //ajax for drop down to choose project
        $('[name="projectForUser"]').on('change', function () {
          $.ajax({
        type: "post",
        url: "{{route('tasks.chooseProject')}}",
        data: {'selected': {'jsonResponse': $('[name="projectForUser"]').val()},
        '_token': '{{ csrf_token() }}'
},
        dataType: "json",
        success: function (response) {
          for (var i = 0; i < {{strlen($tasks)}}; i++) {
            var tasks = {{$tasks}};
            var task = tasks[i];
            myTable.row.add(task).draw();
      }
        }
      });  
      });  
        });
    </script>
@endsection