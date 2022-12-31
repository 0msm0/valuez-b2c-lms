@extends('layout.main')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h4 class="page-title">School Admin User</h4>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Manage School Admin</li>
                        </ol>
                    </nav>
                </div>
            </div>

        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">School Admin</h5>
                        <div class="card-actions float-end">
                            <div class="dropdown show">
                                {{-- <a href="#"
                                    class="waves-effect waves-light btn btn-sm btn-outline btn-info mb-5">Add School Admin</a> --}}
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="yajra-table" class="table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>School Name</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Datetime</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-dark">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- /.content -->
@endsection
@section('script-section')
    <script type="text/javascript">
        $(function() {

            var table = $('#yajra-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('school.admin') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'school_id',
                        name: 'school.school_name'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },                    
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

        });
    </script>
@endsection
