@extends('layout.main')
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">View History</h5>
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
                                        <th>Grade</th>
                                        <th>Course</th>
                                        <th>Instruction Module</th>
                                        <th>Datetime</th>
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
                pageLength: 25,
                order: [],
                ajax: "{{ route('teacher.class.history') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                    },
                    {
                        data: 'grade',
                        name: 'lessonplan.class_id'
                    },
                    {
                        data: 'course',
                        name: 'lessonplan.course_id'
                    },
                    {
                        data: 'lessonplan.title',
                        name: 'lessonplan.title'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                    },

                ]
            });

        });
    </script>
@endsection
