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
      <div class="card">
        <div class="card-header">{{ __('Tasks List') }}</div>
    
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped">
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
                @foreach ($tasks as $task)
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
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
@endsection