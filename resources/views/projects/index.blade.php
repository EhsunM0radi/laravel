@extends('layouts.app')

@section('title','Projects')

@section('content')

@if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="container">
      <a href="{{ route('projects.create') }}" style="display: inline-block;"><h4>Add new Project +</h4></a><br>
      <div class="card">
        <div class="card-header">{{ __('Projects List') }}</div>
    
        <div class="card-body">
          <div class="table-responsive">
            <table id="my-table">
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
                @foreach ($projects as $project)
                  <tr>
                    <td>{{ $project->id }}</td>
                    <td>{{ $project->title }}</td>
                    <td>{{ $project->_creator->name }}</td>
                    <td>{{ $project->description }}</td>
                    <td>
                      @can('destroy', $project)
                      <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{ $project->id }}">
                        Delete
                      </button>
                      @else
                      <button disabled type="button" class="btn btn-danger">
                        Delete
                      </button>
                      @endcan
                      <div class="modal fade" id="deleteModal{{ $project->id }}" tabindex="-1" role="dialog">
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
                              <form action="{{ route('projects.destroy', ['project' => $project]) }}" method="POST">
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
                      @can('edit', $project)
                      <form action="{{ route('projects.edit', ['project' => $project]) }}" method="GET">
                        <button class="btn btn-dark" type="submit">Edit</button>
                      </form>
                      @else
                        <button disabled class="btn btn-dark" type="submit">Edit</button>
                      @endcan
                    </td>
                    <td>
                      @can('show', $project)
                      <form action="{{ route('projects.show', ['project' => $project]) }}" method="GET">
                        <button class="btn btn-primary" type="submit">View</button>
                      </form>
                      @else
                        <button disabled class="btn btn-primary" type="submit">View</button>
                      @endcan
                      
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript">
      $(document).ready(function() {
        $('#my-table').dataTable();
      });
    </script>
@endsection
