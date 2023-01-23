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
                            <li class="breadcrumb-item active" aria-current="page">Sorting Instructional Module</li>
                        </ol>
                    </nav>
                </div>
            </div>

        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-4 col-12">
                <!-- Basic Forms -->
                <div class="box">
                    <div class="box-header with-border">
                        <h4 class="box-title">Select Course</h4>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="form-group">
                            <select class="form-control select2" name="course_id" id="course_id" style="width: 100%;">
                                @foreach ($course_list as $course)
                                <option value="{{ $course->id }}"
                                    {{ $course->id == old('course_id') ? 'selected' : '' }}>
                                    {{ $course->course_name }}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="box-header with-border grade-box">
                        <h4 class="box-title">Grade list</h4>
                    </div>

                    <div class="box-body p-0" id="class_list">
                        {{-- <div class="d-flex align-items-center p-3">
                            <span class="bullet bullet-bar bg-success align-self-stretch"></span>
                            <div class="h-20 mx-20 flex-shrink-0">
                                <input type="radio" name="grade" id="cls2" class="filled-in chk-col-success">
                                <label for="cls2" class="h-20 text-dark hover-success fs-16">Create FireStone 2</label>
                            </div>
                        </div> --}}
                    </div>

                </div>
                <!-- /.box -->
            </div>

            <div class="col-lg-8 col-12">
                <!-- Basic Forms -->
                <div class="box">
                    <div class="box-header with-border">
                        <h4 class="box-title">Drag and drop for arrange sequence</h4>
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body p-0">
                        <div class="media-list media-list-hover media-list-divided">
                            <a class="media media-single" href="#">
                                <i class="fs-18 me-0 flag-icon flag-icon-us"></i>
                                <span class="title text-mute">USA </span>
                                <span class="badge badge-pill badge-secondary-light">125</span>
                            </a>

                            <a class="media media-single" href="#">
                                <i class="fs-18 me-0 flag-icon flag-icon-ba"></i>
                                <span class="title text-mute">Bahrain</span>
                                <span class="badge badge-pill badge-primary-light">124</span>
                            </a>

                            <a class="media media-single" href="#">
                                <i class="fs-18 me-0 flag-icon flag-icon-ch"></i>
                                <span class="title text-mute">China</span>
                                <span class="badge badge-pill badge-info-light">425</span>
                            </a>

                            <a class="media media-single" href="#">
                                <i class="fs-18 me-0 flag-icon flag-icon-de"></i>
                                <span class="title text-mute">Denmark</span>
                                <span class="badge badge-pill badge-success-light">321</span>
                            </a>

                        </div>
                    </div>

                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection

@section('script-section')
    <script type="text/javascript">
        $(function() {
            $('#course_id').change(function() {
                $('.grade-box').hide();
                var courseId = $(this).val();
                $.ajax({
                    url: "{{ route('lesson.plan.sorting') }}",
                    data: {
                        type: 'grade',
                        courseid: courseId
                    }
                }).done(function(res) {
                    // console.log(res);
                    var class_html = '';
                    $.each(res, function(index, value) {
                        // console.log(value);
                        class_html += '<div class="d-flex align-items-center p-3"><span class="bullet bullet-bar bg-success align-self-stretch"></span><div class="h-20 mx-20 flex-shrink-0"><input type="radio" name="grade" id="cls'+value.id+'" class="filled-in chk-col-success"><label for="cls'+value.id+'" class="h-20 text-dark hover-success fs-16">'+value.class_name+'</label></div></div>';                      
                    });
                    $('.grade-box').show();
                    $('#class_list').html(class_html);
                });
            });
        });
    </script>
@endsection
