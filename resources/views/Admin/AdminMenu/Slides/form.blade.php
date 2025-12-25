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
                                <li class="breadcrumb-item"><a href="{{ route('admin.slides') }}">Carousel</a></li>
                                <li class="breadcrumb-item" aria-current="page">Add New Carousel</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Add New Carousel</h2>
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
                                                            name="title_en" placeholder="Enter Title-en" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label" for="descriptionEn">Description-en</label>
                                                        <textarea id="description_en" name="description_en" class="summernote"></textarea>
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
                                                            name="title_kh" placeholder="Enter Title-kh" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label" for="descriptionEn">Description-kh</label>
                                                        <textarea id="description_kh" name="description_kh" class="summernote"></textarea>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label class="form-label">Type</label>
                                                        <select class="form-select" id="type" name="type">
                                                            <option value="carousel">Carousel</option>
                                                            <option value="advertisement">Advertisement</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Url</label>
                                                        <input type="text" class="form-control" id="url"
                                                            name="url" placeholder="Enter url">
                                                    </div>
                                                    <div class="form-check form-switch d-flex align-items-center p-0">
                                                        <label class="form-check-label h5 pe-3 mb-0"
                                                            for="active">Active</label>
                                                        <input
                                                            class="form-check-input h4 m-0 position-relative flex-shrink-0"
                                                            type="checkbox" id="status" name="status"
                                                            checked="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <p><span class="text-danger">*</span> Carousel Picture</p>
                                                        <label class="btn btn-outline-secondary" for="flupld"><i
                                                                class="ti ti-upload me-2"></i> Click to Upload</label>
                                                        <input type="file" id="flupld" onchange="loadFile(event)"
                                                            accept="*" class="d-none">
                                                        <img id="showThumbnail" style="margin-top:15px;max-height:100px;">
                                                    </div>
                                                    <div class="text-end btn-page mb-0 mt-4">
                                                        <button class="btn btn-outline-secondary">Cancel</button>
                                                        <button type="button" class="btn btn-primary"
                                                            onclick="save()">Add
                                                            new
                                                            Carousel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                $('#description_en, #description_kh').val('');
                $('#type').val('');
                $('#status').prop('checked', false);
                $('#flupld').val('');
                $('#showThumbnail').attr('src', '').hide();
                return;
            }

            return {
                title_en: $('#title_en').val(),
                title_kh: $('#title_kh').val(),
                description_en: $('#description_en').val(),
                description_kh: $('#description_kh').val(),
                type: $('#type').val(),
                status: $('#status').is(':checked') ? 1 : 0,
                thumbnail: $('#flupld')[0].files[0] ?? null
            };
        }

        function save() {
            try {
            const data = valueFill();
            let formData = new FormData();

            formData.append('title_en', data.title_en);
            formData.append('title_kh', data.title_kh);
            formData.append('description_en', data.description_en);
            formData.append('description_kh', data.description_kh);
            formData.append('type', data.type);
            formData.append('status', data.status);
            formData.append('image', data.thumbnail);

                $.ajax({
                    url: "{{ route('slides.add') }}",
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
                        window.location.replace("{{ route('admin.slides') }}");
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
    }
</script>
