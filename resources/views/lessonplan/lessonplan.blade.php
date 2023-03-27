@extends('layout.main')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h4 class="page-title">Instructional Module</h4>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Manage Instructional Module</li>
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
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        {{ $message }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Instructional Module</h5>

                        <div class="d-flex float-end">
                            <div id="class-filter" class="px-3"></div>
                            <div id="course-filter" class="px-3"></div>

                            <a href="{{ route('lesson.plan.sorting') }}"
                                class="waves-effect waves-light btn btn-sm btn-outline btn-primary mb-5 me-2">Instructional
                                Sorting
                            </a>
                            <a href="{{ route('lesson.plan.add') }}"
                                class="waves-effect waves-light btn btn-sm btn-outline btn-info mb-5">Add Instructional
                                Module
                            </a>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="yajra-table" class="table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Class Name</th>
                                        <th>Course</th>
                                        <th>Video Link</th>
                                        <th>Status</th>
                                        <th>Demo</th>
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
                pageLength: 25,
                order: [],
                ajax: "{{ route('lesson.plan.list') }}",
                columns: [{
                        data: 'lesson_image',
                        name: 'lesson_image',
                        orderable: false,
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'class_name',
                        name: 'class_id'
                    },
                    {
                        data: 'course_name',
                        name: 'master_course.course_name'
                    },
                    {
                        data: 'video_url',
                        name: 'video_url'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'is_demo',
                        name: 'is_demo'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                initComplete: function() {
                    this.api().column(2).every(function() {
                        var column = this;
                        var select = $(
                                '<select class="default-select form-control wide form-control-sm fw-bolder" id="class-filter"><option value="">All Class</option></select>'
                            )
                            .appendTo($('#class-filter').empty())
                            .on('change', function() {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );
                                column.search(this.value).draw();
                            });
                        @foreach ($class_list as $cdata)
                            select.append(
                                '<option value="{{ $cdata->id }}" data-id="{{ $cdata->id }}">{{ $cdata->class_name }}</option>'
                            );
                        @endforeach
                    });

                    this.api().column(3).every(function() {
                        var column = this;
                        var select = $(
                                '<select class="default-select form-control wide form-control-sm fw-bolder" id="class-filter"><option value="">All Course</option></select>'
                            )
                            .appendTo($('#course-filter').empty())
                            .on('change', function() {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );
                                column.search(this.value).draw();
                            });
                        @foreach ($course_list as $courseData)
                            select.append(
                                '<option value="{{ $courseData->course_name }}" data-id="{{ $courseData->id }}">{{ $courseData->course_name }}</option>'
                            );
                        @endforeach
                    });
                }
            });

        });


        $(document).on('click', '.change_status', function() {
            console.log("hello");
            var id = $(this).attr('data-id');
            var status = $(this).attr('data-status');
            $.ajax({
                url: "{{ route('lesson.demo.status') }}",
                type: "POST",
                data: {
                    lessonid: id,
                    status: status
                },
                success: function(data) {
                    var csts = (status == 1) ? 0 : 1;
                    $('#status_' + id).text(data).attr('data-status', csts);
                    if (csts == 1) {
                        $('#status_' + id).addClass('bg-success').removeClass('bg-danger');
                    } else {
                        $('#status_' + id).addClass('bg-danger').removeClass('bg-success');
                    }
                }
            });
        });
    </script>
@endsection
