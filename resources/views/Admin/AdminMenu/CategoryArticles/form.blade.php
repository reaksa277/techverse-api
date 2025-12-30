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
                                <li class="breadcrumb-item"><a href="{{ route('admin.article') }}">Aritcle</a></li>
                                <li class="breadcrumb-item" aria-current="page">Add New Aritcle</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0 {{ isset($data['id']) && $data['id'] ? 'd-none' : '' }}">Add New Aritcle
                                </h2>
                                <h2 class="mb-0 {{ isset($data['id']) && $data['id'] ? '' : 'd-none' }}">Update Aritcle
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
                            <form id="slideForm" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-8">
                                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                                    data-bs-target="#pills-home" type="button" role="tab"
                                                    aria-controls="pills-home" aria-selected="true">English</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                                    data-bs-target="#pills-profile" type="button" role="tab"
                                                    aria-controls="pills-profile" aria-selected="false">Khmer</button>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="pills-tabContent">
                                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                                aria-labelledby="pills-home-tab" tabindex="0">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="language_en" id="language_en">
                                                            <div class="form-group">
                                                                <label class="form-label">Title-en <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" id="title_en"
                                                                    value="{{ old('title_en', $data['title_en'] ?? '') }}"
                                                                    name="title_en" placeholder="Enter Title-en" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Info-en</label>
                                                                <input type="text" class="form-control" id="info_en"
                                                                    value="{{ old('info_en', $data['info_en'] ?? '') }}"
                                                                    name="info_en" placeholder="Enter Info-en">
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label"
                                                                    for="descriptionEn">Description-en</label>
                                                                <textarea id="description_en" name="description_en" class="summernote">{{ old('description_en', $data['description_en'] ?? '') }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                                aria-labelledby="pills-profile-tab" tabindex="0">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="language_kh" id="language_kh">
                                                            <div class="form-group">
                                                                <label class="form-label">Title-kh <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" id="title_kh"
                                                                    value="{{ old('title_kh', $data['title_kh'] ?? '') }}"
                                                                    name="title_kh" placeholder="Enter Title-kh" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Info-kh</label>
                                                                <input type="text" class="form-control" id="info_kh"
                                                                    value="{{ old('info_kh', $data['info_kh'] ?? '') }}"
                                                                    name="info_kh" placeholder="Enter Info-kh">
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label"
                                                                    for="descriptionEn">Description-kh</label>
                                                                <textarea id="description_kh" name="description_kh" class="summernote">{{ old('description_kh', $data['description_kh'] ?? '') }}</textarea>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label class="form-label">Category</label>
                                                    <select name="category_id" id="category_id" class="form-control">
                                                        <option value="">-- Select Category --</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}"
                                                                {{ $data['category_id'] == $category->id ? 'selected' : '' }}>
                                                                {{ $category->title_en }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Tag</label>
                                                    <input type="text" class="form-control" id="tag"
                                                        value="{{ old('tag', $data['tag'] ?? '') }}" name="tag"
                                                        placeholder="Enter tag">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Url</label>
                                                    <input type="text" class="form-control" id="url"
                                                        value="{{ old('url', $data['url'] ?? '') }}" name="url"
                                                        placeholder="Enter url">
                                                </div>
                                                <div class="form-group">
                                                    <p><span class="text-danger">*</span> Article Picture</p>

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
                                        <a href="{{ route('admin.article') }}"
                                            class="btn btn-outline-secondary">Cancel</a>
                                        <button id="btnSave" type="button" onclick="save()"
                                            class="btn btn-primary {{ isset($data['id']) && $data['id'] ? 'd-none' : '' }}">
                                            Save Article
                                        </button>
                                        <button id="btnUpdate" type="button" onclick="update({{ $data['id'] }})"
                                            class="btn btn-primary {{ isset($data['id']) && $data['id'] ? '' : 'd-none' }}">
                                            Update Article
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

        function valueFill(action = null) {

            if (action === 'clear') {
                $('#title_en, #title_kh').val('');
                $('#info_en, #info_kh').val('');
                $('#description_en, #description_kh').val('');
                $('#category_id').val('');
                $('#status').prop('checked', false);
                $('#tag').val('');
                $('#url').val('');
                $('#flupld').val('');
                $('#showThumbnail').attr('src', '').hide();
                return;
            }

            const data = {
                title_en: $('#title_en').val(),
                title_kh: $('#title_kh').val(),
                info_en: $('#info_en').val(),
                info_kh: $('#info_kh').val(),
                description_en: $('#description_en').val(),
                description_kh: $('#description_kh').val(),
                categoryId: $('#category_id').val(),
                tag: $('#tag').val(),
                url: $('#url').val(),
                status: $('#status').is(':checked') ? 1 : 0,
                thumbnail: $('#flupld')[0].files[0] ?? null
            };

            return data;
        }

        function save() {
            try {
                const data = valueFill();
                let formData = new FormData();

                formData.append('title_en', data.title_en);
                formData.append('title_kh', data.title_kh);
                formData.append('info_en', data.info_en || null);
                formData.append('info_kh', data.info_kh || null);
                formData.append('description_en', data.description_en);
                formData.append('description_kh', data.description_kh);
                formData.append('category_id', data.categoryId);
                formData.append('tag', data.tag);
                formData.append('url', data.url);
                formData.append('status', data.status);
                formData.append('image', data.thumbnail);

                $.ajax({
                    url: "{{ route('article.add') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status == "error") {
                            validationMgs(response);
                            return;
                        }
                        unblockagePage();
                        window.location.replace("{{ route('admin.article') }}");
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

            formData.append('title_en', data.title_en);
            formData.append('title_kh', data.title_kh);
            formData.append('info_en', data.info_en);
            formData.append('info_kh', data.info_kh);
            formData.append('description_en', data.description_en);
            formData.append('description_kh', data.description_kh);
            formData.append('category_id', data.categoryId);
            formData.append('status', data.status);
            formData.append('tag', data.tag);
            formData.append('image', data.thumbnail);

            formData.append('_method', 'PUT');
            $.ajax({
                url: "{{ url('/api/articles') }}/" + id,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status == "error") {
                        validationMgs(response);
                        return;
                    }
                    unblockagePage();
                    window.location.replace("{{ route('admin.article') }}");
                },
                error: function(e) {
                    Msg(e, 'error');
                    unblockagePage();
                }
            })
        }
    }
</script>
