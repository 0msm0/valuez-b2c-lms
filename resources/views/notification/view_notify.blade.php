@extends('layout.main')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h4 class="page-title">What's New</h4>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Manage What's New</li>
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
                        <h5 class="card-title mb-0">What's New</h5>
                        <div class="card-actions float-end">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="yajra-table" class="table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Description</th>
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
                ajax: "{{ route('notify.schoolview') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    }
                ]
            });

        });
    </script>
@endsection
