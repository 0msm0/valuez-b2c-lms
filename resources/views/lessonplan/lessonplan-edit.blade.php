@extends('layout.main')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h4 class="page-title">Program</h4>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page">Manage Program</li>
                            <li class="breadcrumb-item active" aria-current="page">Program Edit</li>
                        </ol>
                    </nav>
                </div>
            </div>

        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-10 col-xl-8 col-12">
                <!-- Basic Forms -->
                <div class="box">
                    <div class="box-header with-border">
                        <h4 class="box-title">Add New Lesson Plan</h4>
                    </div>
                    <!-- /.box-header -->
                    <form action="{{ route('lesson.plan.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label class="form-label">Lesson Plan Title</label>
                                <input type="text" name="title" value="{{ $lessonplan->title }}" class="form-control"
                                    placeholder="Enter Lesson Plan Title">
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">Program</label>
                                <select class="form-control select2" name="class_id" style="width: 100%;">
                                    @foreach ($program_list as $prog)
                                        <option value="{{ $prog->id }}"
                                            {{ $prog->id == $lessonplan->class_id ? 'selected' : '' }}>
                                            {{ $prog->class_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Course</label>
                                <select class="form-control select2" name="course_id" style="width: 100%;">
                                    @foreach ($course_list as $course)
                                        <option value="{{ $course->id }}"
                                            {{ $course->id == $lessonplan->course_id ? 'selected' : '' }}>
                                            {{ $course->course_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Video Link</label>
                                <input type="text" name="video_url" class="form-control"
                                    value="{{ $lessonplan->video_url }}" placeholder="Enter Video Link">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Instructions Video Link</label>
                                <input type="text" name="video_info_url" class="form-control"
                                    value="{{ $lessonplan->video_info_url }}" placeholder="Enter Instructions Video Link">
                            </div>


                            <div class="form-group">
                                <label class="form-label">Lesson No</label>
                                <input type="text" name="lesson_no" class="form-control"
                                    value="{{ $lessonplan->lesson_no }}" placeholder="Enter Lesson No">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Lesson Instructions</label>
                                <textarea id="lesson_inst" name="lesson_desc" class="form-control" placeholder="Enter Lesson Instructions">{{ $lessonplan->lesson_desc }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="formFile" class="form-label">Lesson Plan Image <span
                                        class="text-danger">*</span></label>
                                <input class="form-control" type="file" name="image" id="formFile">
                                <img src="{{ url('uploads/lessonplan') }}/{{ $lessonplan->lesson_image ? $lessonplan->lesson_image : 'no_image.png' }}"
                                    width="100px">
                            </div>
                            <hr>
                            <div class="form-group">
                                <label class="form-label">Status</label>
                                <div class="c-inputs-stacked">
                                    <input name="status" type="radio" id="active" value="1"
                                        {{ $lessonplan->status == 1 ? 'checked' : '' }}>
                                    <label for="active" class="me-30">Active</label>
                                    <input name="status" type="radio" id="inactive" value="0"
                                        {{ $lessonplan->status == 0 ? 'checked' : '' }}>
                                    <label for="inactive" class="me-30">Inactive</label>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <input type="hidden" name="id" value="{{ $lessonplan->id }}">
                            <input type="hidden" name="old_image" value="{{ $lessonplan->lesson_image }}">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>

        </div>
    </section>
    <!-- /.content -->
@endsection

@section('script-section')
    <script src="{{ asset('assets/vendor_plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.js') }}"></script>

    <script>
        $('.select2').select2();
        //Add text editor

        //bootstrap WYSIHTML5 - text editor
        $('#lesson_inst').wysihtml5();
    </script>
@endsection
