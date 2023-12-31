<div class="container mt-4">
                <h1>{{ __('Create New project') }}</h1>

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

                            <div id="selectedUsersContainer">
                                <h6>Roles: </h6><br>
                                <!-- Selected users will be displayed here -->
                            </div><br>
                            

                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Submit') }}
                            </button>
                        </div>
                    </form>
</div>
<script>
$(document).ready(function() {
    $('.js-example-basic-multiple').select2(); // Initialize the select2 plugin

    var selectedUsersAndRoles = [];

    var selectedUsersContainer = $('#selectedUsersContainer');

    function updateUserRole(index, newRole) {
        selectedUsersAndRoles[index].role = newRole;
    }

    function rebuildUI() {
        selectedUsersContainer.empty();

        $.each(selectedUsersAndRoles, function(index, userRole) {
            selectedUsersContainer.append(`<p style="display:inline-block">${userRole.name}</p>&nbsp`);

            var selectElement = $('<select>', {
                class: 'js-example-basic-single',
                name: 'role' + index,
                id: `${userRole.name}-role`
            });

            @foreach ($roles as $role)
                var option = $('<option>', {
                    value: '{{ $role }}',
                    text: '{{ $role }}'
                });

                if ('{{ $role }}' === userRole.role) {
                    option.attr('selected', 'selected');
                }

                selectElement.append(option);
            @endforeach

            selectedUsersContainer.append(selectElement).append('<br>');

            if (!selectElement.hasClass('select2-hidden-accessible')) {
                selectElement.select2();

                selectElement.on('change', function() {
                    var newRole = $(this).val();
                    updateUserRole(index, newRole);

                    // Use setTimeout to update the UI after a small delay
                    setTimeout(function() {
                        rebuildUI();
                    }, 100);
                });
            }
        });
    }

    // Initial UI setup
    rebuildUI();

    $('#selectedUsers').on('change', function() {
        // Update selectedUsersAndRoles array based on the UI
        selectedUsersAndRoles = [];
        
        $('.js-example-basic-multiple option:selected').each(function() {    
            var userId = $(this).val();
            var userName = $(this).text();
            var existingUserRole = $('#'+ userName +'-role').val();
            var userRole = {
                id: userId,
                name: userName,
                role: existingUserRole ? existingUserRole : ''
            };

            selectedUsersAndRoles.push(userRole);
        });

        // Rebuild the UI
        rebuildUI();
    });
});

</script>