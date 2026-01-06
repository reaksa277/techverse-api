@extends('Admin.Layouts.master')

@section('content')
    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.users') }}">User</a></li>
                                <li class="breadcrumb-item" aria-current="page">Add New User</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0 {{ isset($data['id']) && $data['id'] ? 'd-none' : '' }}">Add New User
                                </h2>
                                <h2 class="mb-0 {{ isset($data['id']) && $data['id'] ? '' : 'd-none' }}">Update User
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            {{-- Tap menu --}}
            <div class="panel-container show">
                <div class="panel-content">
                    <div class="card">
                        <div class="card-body">
                            <form id="userForm" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label class="form-label">Name <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="name"
                                                        value="{{ old('name', $data['name'] ?? '') }}" name="name"
                                                        placeholder="Enter Name" required>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Email address <span
                                                            class="text-danger">*</span></label>
                                                    <input type="email" id="email" class="form-control form-control"
                                                        value="{{ old('email', $data['email'] ?? '') }}" name="email"
                                                        placeholder="email@company.com">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label" for="password">Password <span
                                                            class="text-danger">*</span></label>
                                                    <input type="password" class="form-control" id="password"
                                                        value="{{ old('password', $data['password'] ?? '') }}"
                                                        name="password" placeholder="Password" required>
                                                    <small>Your password must be between 8 and 30 characters.</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label class="form-label">Role</label>
                                                    <select class="form-select" id="role" name="role">
                                                        <option value="admin"
                                                            {{ old('role', $data['role'] ?? '') == 'admin' ? 'selected' : '' }}>
                                                            Admin</option>
                                                        <option value="user"
                                                            {{ old('role', $data['role'] ?? '') == 'user' ? 'selected' : '' }}>
                                                            User</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <p>Avatar Picture</p>

                                                    <!-- Custom upload button -->
                                                    <label class="btn btn-outline-secondary" for="flupld">
                                                        <i class="ti ti-upload me-2"></i> Click to Upload
                                                    </label>

                                                    <!-- Hidden file input -->
                                                    <input type="file" id="flupld" name="image" accept="image/*"
                                                        class="d-none" onchange="loadFile(event)">

                                                    <!-- Preview image -->
                                                    <img id="showThumbnail" style="margin-top:15px;max-height:100px;"
                                                        src="{{ old('image', isset($data['image']) ? asset('storage/' . $data['image']) : '') }}">
                                                </div>
                                                <div class="form-check form-switch d-flex align-items-center p-0 my-2">
                                                    <label class="form-check-label h5 pe-3 mb-0"
                                                        for="status">Active</label>
                                                    <input class="form-check-input h4 m-0 position-relative flex-shrink-0"
                                                        type="checkbox" id="status" name="status"
                                                        {{ old('status', $data['status'] ?? 0) ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Card Footer with buttons -->
                                    <div class="text-end">
                                        <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary">Cancel</a>
                                        <button id="btnSave" type="button" onclick="save()"
                                            class="btn btn-primary {{ isset($data['id']) && $data['id'] ? 'd-none' : '' }}">
                                            Save User
                                        </button>
                                        <button id="btnUpdate" type="button" onclick="update({{ $data['id'] }})"
                                            class="btn btn-primary {{ isset($data['id']) && $data['id'] ? '' : 'd-none' }}">
                                            Update User
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->
@endsection
<script>
    {
        var loadFile = function(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('showThumbnail');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        };
        let updateRoute = "{{ route('users.update', ':id') }}";

        function valueFill(action = null) {

            if (action === 'clear') {
                $('#name').val('');
                $('#email').val('');
                $('#password').val('');
                $('#role').val('');
                $('#status').prop('checked', false);
                $('#flupld').val('');
                $('#showThumbnail').attr('src', '').hide();
                return;
            }

            return {
                name: $('#name').val(),
                email: $('#email').val(),
                password: $('#password').val(),
                role: $('#role').val(),
                status: $('#status').is(':checked') ? 1 : 0,
                thumbnail: $('#flupld')[0].files[0] ?? null
            };
        }

        function save() {
            try {
                const data = valueFill();
                let formData = new FormData();

                formData.append('name', data.name);
                formData.append('email', data.email);
                formData.append('password', data.password);
                formData.append('role', data.role);
                formData.append('status', data.status);
                formData.append('image', data.thumbnail);

                $.ajax({
                    url: "{{ route('users.add') }}",
                    type: "POST",
                    headers: {
                        Authorization: 'Bearer {{ session('auth_token') }}',
                        Accept: "application/json",
                    },
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status == "error") {
                            validationMgs(response);
                            return;
                        }
                        unblockagePage();

                        window.location.replace("{{ route('admin.users') }}");
                    },
                    error: function(e) {
                        Msg(e, 'error');
                        unblockagePage();
                    }
                })
            } catch (err) {
                console.error(err);
            }
        }

        function update(id) {
            const data = valueFill();
            let formData = new FormData();

            formData.append('name', data.name);
            formData.append('email', data.email);
            formData.append('password', data.password);
            formData.append('role', data.role);
            formData.append('status', data.status);
            formData.append('image', data.thumbnail);

            formData.append('_method', 'PUT');

            let urlUpdate = updateRoute.replace(':id', id);
            $.ajax({
                url: urlUpdate,
                type: "POST",
                headers: {
                    Authorization: 'Bearer {{ session('auth_token') }}',
                    Accept: "application/json",
                },
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status == "error") {
                        validationMgs(response);
                        return;
                    }
                    unblockagePage();
                    window.location.replace("{{ route('admin.users') }}");
                },
                error: function(e) {
                    Msg(e, 'error');
                    unblockagePage();
                }
            })
        }
    }
</script>
