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
                            <li class="breadcrumb-item" aria-current="page">Manage Lesson Plan </li>
                            <li class="breadcrumb-item active" aria-current="page">Lesson Plan Add</li>
                        </ol>
                    </nav>
                </div>
            </div>

        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-8 col-12">
                <!-- Basic Forms -->
                <div class="box">
                    <div class="box-header with-border">
                        <h4 class="box-title">Add New Lesson Plan</h4>
                    </div>
                    <!-- /.box-header -->
                    <form action="{{ route('lesson.plan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label class="form-label">Lesson Plan Title</label>
                                <input type="text" name="title" class="form-control"
                                    placeholder="Enter Lesson Plan Title">
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Video Link</label>
                                <input type="text" class="form-control" placeholder="Enter Video Link">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Lesson No</label>
                                <input type="text" class="form-control" placeholder="Enter Lesson No">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Program</label>
                                <select class="form-control select2" style="width: 100%;">
                                    @foreach ($program_list as $prog)
                                        <option value="{{ $prog->id }}}">{{ $prog->class_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Course</label>
                                <select class="form-control select2" style="width: 100%;">
                                    @foreach ($course_list as $course)
                                        <option value="{{ $course->id }}}">{{ $course->course_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="formFile" class="form-label">Lesson Plan Image <span
                                        class="text-danger">*</span></label>
                                <input class="form-control" type="file" name="image" id="formFile">
                                @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <hr>
                            <div class="form-group">
                                <label class="form-label">Status</label>
                                <div class="c-inputs-stacked">
                                    <input name="status" type="radio" id="active" value="1" checked>
                                    <label for="active" class="me-30">Active</label>
                                    <input name="status" type="radio" id="inactive" value="0">
                                    <label for="inactive" class="me-30">Inactive</label>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
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
    <script>
        $('.select2').select2();
    </script>
@endsection
