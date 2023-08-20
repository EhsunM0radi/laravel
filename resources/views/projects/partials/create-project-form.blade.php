<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create New project') }}</div>

                <div class="card-body">
                    <form action="{{ route('projects.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="title">{{ __('Title') }}</label>
                            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="" required autofocus>
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                            <input id="creator" type="hidden" class="form-control @error('creator') is-invalid @enderror" name="creator" value="{{$user->id}}" required>
                            @error('creator')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        

                        <div class="form-group">
                            <label for="description">{{ __('Description') }}</label>
                            <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" rows="4" required></textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{ __('Collaborator') }}</label><br>
                            <select id="selectedUsers" class="js-example-basic-multiple" name="users[]" multiple="multiple">
                                @foreach ($users as $_user)
                                    @if($_user->id != $user->id)
                                    <option value="{{$_user->id}}">{{$_user->name}}</option>
                                    @endif
                                @endforeach
                              </select>
                            </div>



                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Submit') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

    $('.js-example-basic-multiple').select2(); // Initialize the select2 plugin
    $('#selectedUsers').on('change', function() {
        var selectedUserIds = $(this).val(); // Get an array of selected user IDs

        // Make an AJAX request to send the selectedUserIds to the server
        $.ajax({
            type: 'POST',
            url: '{{ route('projects.handle.selected.users') }}', // Replace with your actual route URL
            data: { _token: '{{ csrf_token() }}', selectedUsers: selectedUserIds },
            success: function(response) {
                // Process the response from the server if needed
                var selectedUsersContainer = $('#selectedUsersContainer');
                selectedUsersContainer.empty();

                let count = 0;
                $.each(response.selectedUsers, function(index, user) {
                    selectedUsersContainer.append(`<p>${user.name}</p>`);

                    // Create a new <select> element for the role
                    var selectElement = $('<select>', {
                        class: 'js-example-basic-single', // Use single selection for roles
                        name: 'role'+String(count)
                    });

                    // Loop through the roles and add options to the <select> element
                    @foreach ($roles as $role)
                        selectElement.append($('<option>', {
                            value: '{{ $role }}',
                            text: '{{ $role }}'
                        }));
                    @endforeach

                    // Append the <select> element to the container
                    selectedUsersContainer.append(selectElement);
                    count++;
                });

                // Initialize Select2 for the new <select> element(s)
                $('.js-example-basic-single').select2(); // Use correct class for single selection
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    });
});

</script>
