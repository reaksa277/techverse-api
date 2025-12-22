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
                                <h5 class="m-b-10">Slides</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item" aria-current="page">Slides</li>
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
                                <button class="btn btn-primary" onclick="create()">
                                    <i class="ti ti-plus f-18"></i> Add Slide
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table id="datalist" class="table table-hover table-striped w-100">
                                    <thead>
                                        <tr>
                                            <th class="text-end">#</th>
                                            <th>Title_en</th>
                                            <th>Title_kh</th>
                                            <th>Descpition_en</th>
                                            <th>Descpition_kh</th>
                                            <th class="text-end">Image</th>
                                            <th class="text-end">Type</th>
                                            <th>Created At</th>
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
    @include('Admin.AdminMenu.Slides.form')

    <script>
        {
            $(document).ready(() => {
                getData();
            });

            function create() {
                // $('#formModal').modal();
                console.log("open model");
            }

            function getData() {
                $.ajax({
                    url: "/api/slides",
                    type: "GET",
                    success: function(response) {
                        console.log("get slide: ", response.data);
                        dataList(response.data)
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }

            // datatable data
            function dataList(data) {
                var cols = [{
                        'data': 'id',
                        'name': 'id',
                        'searchable': true,
                        'orderable': true,
                        'visible': true,
                    },
                    {
                        'data': 'title_en',
                        'name': 'title_en',
                        'searchable': true,
                        'orderable': true,
                        'visible': true,
                    },
                    {
                        'data': 'title_kh',
                        'name': 'title_kh',
                        'searchable': true,
                        'orderable': true,
                        'visible': true,
                    },
                    {
                        'data': 'description_en',
                        'name': 'description_en',
                        'searchable': true,
                        'orderable': true,
                        'visible': true,
                    },
                    {
                        'data': 'description_kh',
                        'name': 'description_kh',
                        'searchable': true,
                        'orderable': true,
                        'visible': true,
                    },
                    {
                        'data': 'image',
                        'name': 'image',
                        'searchable': true,
                        'orderable': true,
                        'visible': true,
                        render: function(thumbnail, type, row) {

                            return `<img src="${thumbnail}" alt="thumbnail" width="80px">`;
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
                        'data': 'created_at',
                        'name': 'created_at',
                        'searchable': true,
                        'orderable': true,
                        'visible': true,
                        render: function(created_at, type, row) {
                            return moment(created_at).format('DD-MMM-YYYY');
                        }
                    },

                ];
                $('#datalist').DataTable().destroy();

                //////INT TABLE//////
                $('#datalist').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ url('api/slides') }}",
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
                            console.log('ERR');
                        }
                    },
                    columns: cols,
                });
                //////INT TABLE//////
            }

        }
    </script>
@endsection
