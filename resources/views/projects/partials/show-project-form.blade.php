<?php use App\Models\ProjectUser; ?>
<div class="container">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('project') }}</div>

                <div class="card-body">
                    <form action="#" >
                        @csrf
                        <div class="form-group">
                            <label for="title">{{ __('Title') }}</label>
                            <input id="title" disabled type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{$project['title']}}" required autofocus>
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="creator">{{ __('Creator') }}</label>
                            <input id="creator" disabled type="text" class="form-control @error('creator') is-invalid @enderror" name="creator" value="{{$project->_creator->name}}" required>
                            @error('creator')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">{{ __('Description') }}</label>
                            <textarea id="description" disabled class="form-control @error('description') is-invalid @enderror" name="description" rows="4" required>{{$project['description']}}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{ __('Collaborator') }}</label><br>
                            <ul>
                                @foreach ($users as $_user)
                                    @if($_user->id != $project->_creator->id)
                                    @if($projectUsers->contains('user_id', $_user->id))
                                    <li>{{$_user->name}}: {{(ProjectUser::where('project_id',$project->id)->where('user_id',$_user->id)->value('type'))}}</li>
                                    
                                    @endif
                                    @endif
                                @endforeach
                            </ul>
                            </div>

                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary" disabled>
                                {{ __('Submit') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>