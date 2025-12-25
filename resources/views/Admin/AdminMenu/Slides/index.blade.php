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
                            <div class="page-header-title">
                                <h5 class="m-b-10">Carousel</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item" aria-current="page">Carousel</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <div class="row">
                <!-- [ sample-page ] start -->
                <div class="col-sm-12">
                    <div class="card table-card">
                        <div class="card-body">
                            <div class="text-end p-4 pb-0">
                                <a class="btn btn-primary" href="{{ route('slides.create') }}">
                                    <i class="ti ti-plus f-18"></i> Add Slide
                                </a>
                            </div>
                            <div class="table-responsive">
                                <table id="datalist" class="table table-hover table-striped w-100">
                                    <thead>
                                        <tr>
                                            <th class="text-end">#</th>
                                            <th>Image</th>
                                            <th>Title_en</th>
                                            <th>Title_kh</th>
                                            <th>Descprition_en</th>
                                            <th>Descprition_kh</th>
                                            <th>Type</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ sample-page ] end -->
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>

    <script>
        {
            $(document).ready(function() {
                dataList();
            });

            // datatable data
            function dataList() {
                var cols = [{
                        'data': 'id',
                        'name': 'id',
                        'searchable': true,
                        'orderable': true,
                        'visible': true,
                        render: function(id, type, row) {
                            return id;
                        }
                    },
                    {
                        'data': 'image',
                        'name': 'image',
                        'searchable': false,
                        'orderable': false,
                        'visible': true,
                        render: function(image, type, row) {
                            return image ?
                                `<img src="/storage/${image}" width="80" style="border-radius: 8px">` :
                                '';
                        }
                    },
                    {
                        'data': 'title_en',
                        'name': 'title_en',
                        'searchable': true,
                        'orderable': true,
                        'visible': true,
                        render: function(title_en, type, row) {
                            return title_en ? title_en :
                                `<span class="text-body-tertiary">N/A</span>`;
                        }
                    },
                    {
                        'data': 'title_kh',
                        'name': 'title_kh',
                        'searchable': true,
                        'orderable': true,
                        'visible': true,
                        render: function(title_kh, type, row) {
                            return title_kh ? title_kh :
                                `<span class="text-body-tertiary">N/A</span>`;
                        }
                    },
                    {
                        'data': 'description_en',
                        'name': 'description_en',
                        'searchable': true,
                        'orderable': true,
                        'visible': true,
                        render: function(description_en, type, row) {
                            return description_en ? description_en :
                                `<span class="text-body-tertiary">N/A</span>`;
                        }
                    },
                    {
                        'data': 'description_kh',
                        'name': 'description_kh',
                        'searchable': false,
                        'orderable': true,
                        'visible': true,
                        render: function(description_kh, type, row) {
                            return description_kh ? description_kh :
                                `<span class="text-body-tertiary">N/A</span>`;
                        }
                    },
                    {
                        'data': 'type',
                        'name': 'type',
                        'searchable': true,
                        'orderable': true,
                        'visible': true,
                    },
                    {
                        "data": null,
                        "name": "Action",
                        "searchable": false,
                        "orderable": false,
                        "visible": true,
                        "class": "dt-center",
                        render: function(data, type, row, meta) {

                            var str =
                                '<div class="dropdown">' +
                                '<button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fal fa-cog" aria-hidden="true"></i></button>' +
                                '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">' +
                                '<a class="dropdown-item" href="javascript:void(0);" onclick="edit(' + row.id +
                                ')"> <i class="fal fa-pencil" aria-hidden="true"></i> Edit</a>' +
                                '<a class="dropdown-item" href="javascript:void(0);" onclick="destroy(' + row
                                .id +
                                ')"> <i class="fal fa-trash" aria-hidden="true"></i> Remove</a>' +
                                '</div>' +
                                '</div>';
                            return str;

                        }

                    },

                ];
                if ($.fn.DataTable.isDataTable('#datalist')) {
                    $('#datalist').DataTable().clear();
                    $('#datalist').DataTable().destroy();
                }

                //////INT TABLE//////
                $('#datalist').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('slides.get-data') }}",
                        type: 'GET',
                        data: function(d) {
                            d.draw = d.draw;
                            d.start = d.start;
                            d.length = d.length;
                            d.search = d.search;
                            d.order = [{
                                column: d.order[0].column,
                                dir: d.order[0].dir
                            }];
                        },
                        error: function(xhr, error, thrown) {
                            // Handle error if needed
                            console.error('ERR');
                        }
                    },
                    columns: cols,
                });
                //////INT TABLE//////
            }
        }
    </script>
@endsection
