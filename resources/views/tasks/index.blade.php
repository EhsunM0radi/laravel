@extends('layouts.app')

@section('title','Tasks')

@section('content')

@if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="container">
      <a id="addTask" href="{{ route('tasks.create') }}" style="display: inline-block;"><h4>Add new Task +</h4></a><br>
      <span>
        <select class="js-example-basic-multiple" id="projectForUser">
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
            <table id="table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Title</th>
                  <th>Creator</th>
                  <th>Description</th>
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
                      <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{ $task->id }}" {{($user->id==$task->creator)?'':'disabled';}}>
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
                @foreach ($tasks as $task)
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
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <script>
      $(document).ready(function () {
        
        //initialize the datatables plugin on my table element
        $('#table').DataTable({
          ajax: {
        type: 'post',
        url: '{{ route("tasks.getTable") }}',
        data: {
            project_id: $('#projectForUser').val(),
            _token: '{{ csrf_token() }}'
        },
        dataSrc: 'data'
    },
    columns: [
        { data: 'id' },
        { data: 'title' },
        {
            data: '_creator', // Access the whole _creator object
            render: function(data, type, row) {
                return data; // Access _creator.name
            }
        },
        { data: 'description' },
        {
            data: 'id',
            render: function(data, type, row) {
                return `<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal${data}">
                  Delete
                  </button>`;
            }
        },
        {
            data: 'id',
            render: function(data, type, row) {
              var editUrl = "{{ route('tasks.edit', ['taskId' => 'TaskID']) }}";
              editUrl = editUrl.replace('TaskID', data);
              return '<form action="' + editUrl + '" method="GET"><button class="btn btn-dark" type="submit">Edit</button></form>';
            }  
      },
        {
            data: 'id',
            render: function(data, type, row) {
              var viewUrl = "{{ route('tasks.show', ['taskId' => 'TaskID']) }}";
              viewUrl = viewUrl.replace('TaskID', data);
              return '<form action="' + viewUrl + '" method="GET"><button class="btn btn-primary" type="submit">View</button></form>';
            }
        }
    ]
            });

    var projectForUser = $('#projectForUser');

    // change href of addTask link
    var projectId = projectForUser.val();
    var newUrl = "{{ route('tasks.create') }}?project_id=" + projectId;
    $("#addTask").attr("href", newUrl);

        //ajax for drop down to choose project
        projectForUser.on('change', function () {
          $.ajax({
        type: "post",
        url: "{{route('tasks.chooseProject')}}",
        data: {'selected': {'jsonResponse': projectForUser.val()},
        '_token': '{{ csrf_token() }}'
},
        dataType: "json",
        success: function (response) {
          console.log(response);
          // Destroy the DataTables instance
    $('#table').DataTable().destroy();
    
    // change href of addTask link
    projectId = projectForUser.val();
    newUrl = "{{ route('tasks.create') }}?project_id=" + projectId;
    $("#addTask").attr("href", newUrl);

        //initialize the datatables plugin on my table element
        $('#table').DataTable({
          ajax: {
        type: 'post',
        url: '{{ route("tasks.getTable") }}',
        data: {
            project_id: projectForUser.val(),
            _token: '{{ csrf_token() }}'
        },
        dataSrc: 'data'
    },
    columns: [
        { data: 'id' },
        { data: 'title' },
        {
            data: '_creator', // Access the whole _creator object
            render: function(data, type, row) {
                return data; // Access _creator.name
            }
        },
        { data: 'description' },
        {
            data: 'id',
            render: function(data, type, row) {
              return `<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal${data}">
                  Delete
                  </button>`;
            }
        },
        {
            data: 'id',
            render: function(data, type, row) {
              var editUrl = "{{ route('tasks.edit', ['taskId' => 'TaskID']) }}";
              editUrl = editUrl.replace('TaskID', data);
              return '<form action="' + editUrl + '" method="GET"><button class="btn btn-dark" type="submit">Edit</button></form>';
            }
        },
        {
            data: 'id',
            render: function(data, type, row) {
              var viewUrl = "{{ route('tasks.show', ['taskId' => 'TaskID']) }}";
              viewUrl = viewUrl.replace('TaskID', data);
              return '<form action="' + viewUrl + '" method="GET"><button class="btn btn-primary" type="submit">View</button></form>';
            }
        }
    ]
            });
        }
      });  
      });  
        });
    </script>
@endsection