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
                    <ul class="nav nav-pills justify-content-end" role="tablist">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="javascript:;"
                                onclick="chooseLanguage('kh')">Khmer</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="javascript:;"
                                onclick="chooseLanguage('en')">English</a></li>
                    </ul>
                </div>
            </div>
            <!-- [ Main Content ] start -->
            <div class="row">
                <!-- [ sample-page ] start -->
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form id="slideForm" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
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
                                                <div class="form-group">
                                                    <label class="form-label">Type</label>
                                                    <select class="form-select" id="type" name="type">
                                                        <option value="carousel">Carousel</option>
                                                        <option value="advertisement">Advertisement</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Url</label>
                                                    <input type="text" class="form-control" id="url" name="url"
                                                        placeholder="Enter url">
                                                </div>
                                                <div class="form-check form-switch d-flex align-items-center p-0">
                                                    <label class="form-check-label h5 pe-3 mb-0"
                                                        for="active">Active</label>
                                                    <input class="form-check-input h4 m-0 position-relative flex-shrink-0"
                                                        type="checkbox" id="status" name="status" checked="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
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
                                                <div class="form-group">
                                                    <p><span class="text-danger">*</span> Carousel Picture</p>
                                                    <label class="btn btn-outline-secondary" for="flupld"><i
                                                            class="ti ti-upload me-2"></i> Click to Upload</label>
                                                    <input type="file" id="flupld" class="d-none">
                                                    <img src="" alt="thumbnail" id="showThumbnail"
                                                        style="margin-top:15px;max-height:100px;">
                                                </div>
                                                <div class="text-end btn-page mb-0 mt-4">
                                                    <button class="btn btn-outline-secondary">Cancel</button>
                                                    <button type="button" class="btn btn-primary" onclick="save()">Add
                                                        new
                                                        Carousel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- [ sample-page ] end -->
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
    <!-- [ Main Content ] end -->
@endsection
<script>
    // var route_prefix = "/filemanager";
    // $('#flupld').filemanager('image', {
    //     prefix: route_prefix
    // });

    function chooseLanguage(language) {
        if (language === 'kh') {
            $('.language_en').hide();
            $('.language_kh').show();
        } else {
            $('.language_en').show();
            $('.language_kh').hide();
        }
    }

    function valueFill(val = null) {
        let title_en;
        let title_kh;
        let description_en;
        let description_kh;
        let type;
        let status;
        let thumbnailimgBack;

        if (val === null) {
            title_en = $('#title_en').val();
            title_kh = $('#title_kh').val();
            description_en = $('#description_en').val();
            description_kh = $('#description_kh').val();
            type = $('#type').val();
            status = $('#status').val();
            thumbnailimgBack = $('#thumbnailimgBack').val();
        }

        if (val === 'clear') {
            $('#title_en').val('');
            $('#title_kh').val('');
            $('#description_en').val('');
            $('#description_kh').val('');
            $('#type').val('');
            $('#status').val('');
            $('#thumbnailimgBack').val('');
        }

        return {
            'title_en': title_en,
            'title_kh': title_kh,
            'description_en': description_en,
            'description_kh': description_kh,
            'type': type,
            'status': status,
            'thumbnailimgBack': thumbnailimgBack,
        }
    }

    function save() {
        try {
            $.ajax({
                url: "{{ route('slides.add') }}",
                type: "POST",
                data: valueFill(),
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
</script>
