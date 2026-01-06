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
                                <h5 class="m-b-10">Category Articles</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item" aria-current="page">Category Articles</li>
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
                                <a class="btn btn-primary" href="{{ route('categoryarticles.create') }}">
                                    <i class="ti ti-plus f-18"></i> Add Category
                                </a>
                            </div>
                            <div class="table-responsive">
                                <table id="datalist" class="table table-hover table-striped w-100">
                                    <thead>
                                        <tr>
                                            <th class="text-end">#</th>
                                            <th>Image</th>
                                            <th>Title</th>
                                            <th>Decription</th>
                                            <th>Type</th>
                                            <th>Status</th>
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

            let editRoute = "{{ route('categoryarticles.edit', ':id') }}";
            let deleteRoute = "{{ route('categoryarticles.delete', ':id') }}";

            function destroy(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to Deleted now!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    let urlDelete = deleteRoute.replace(':id', id);
                    if (result.value) {
                        $.ajax({
                            url: urlDelete,
                            type: "DELETE",
                            headers: {
                                'Authorization': 'Bearer {{ session('auth_token') }}',
                                'Accept': 'application/json',
                            },
                            success: function(response) {
                                unblockagePage();
                                window.location.reload();
                            },
                            error: function(e) {
                                Msg('Error Saving User', 'error');
                                unblockagePage();
                            }
                        });
                    }
                });
            }

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
                            return title_en + ' - [' + row.title_kh + ']';
                        }
                    },
                    {
                        'data': 'description_en',
                        'name': 'description_en',
                        'searchable': false,
                        'orderable': true,
                        'visible': true,
                        render: function(description_en, type, row) {
                            return description_en + ' - [' + row.description_kh + ']';
                        }
                    },
                    {
                        'data': 'type',
                        'name': 'status',
                        'searchable': true,
                        'orderable': true,
                        'visible': true,
                        className: 'text-center',
                        render: function(status, type, row) {
                            return status;
                        }
                    },
                    {
                        'data': 'status',
                        'name': 'status',
                        'searchable': true,
                        'orderable': true,
                        'visible': true,
                        className: 'text-center',
                        render: function(status, type, row) {
                            return status;
                        }
                    },
                    {
                        "data": null,
                        "name": "Action",
                        "searchable": false,
                        "orderable": false,
                        "visible": true,
                        "class": "dt-center",
                        render: function(data, type, row, meta) {

                            var str = `
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ti ti-menu-2"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="${editRoute.replace(':id', row.id)}">
                                                <i class="ti ti-edit"></i> Edit
                                            </a>
                                            <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="destroy(${row.id})">
                                                <i class="ti ti-trash"></i> Remove
                                            </a>
                                        </div>
                                    </div>
                                    `;
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
                        url: "{{ route('categoryarticles.get-data') }}",
                        type: 'GET',
                        headers: {
                            'Authorization': 'Bearer {{ session('auth_token') }}',
                            'Accept': 'application/json',
                        },
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
