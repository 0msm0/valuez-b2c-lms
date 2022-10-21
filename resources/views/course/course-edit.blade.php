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
                            <li class="breadcrumb-item" aria-current="page">Manage Course</li>
                            <li class="breadcrumb-item active" aria-current="page">Course Edit</li>
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
                        <h4 class="box-title">Update Course</h4>
                    </div>
                    <!-- /.box-header -->
                    <form action="{{ route('course.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label class="form-label">Course Title <span class="text-danger">*</span></label>
                                <input type="text" value="{{ $course->course_name }}" name="title" class="form-control"
                                    placeholder="Enter Course Title">
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="formFile" class="form-label">Course Image</label>
                                <input class="form-control" type="file" name="image" id="formFile">
                                <img src="{{ url('uploads/course') }}/{{ $course->course_image ? $course->course_image : 'no_image.png' }}"
                                    width="100px">
                            </div>
                            <hr>
                            <div class="form-group">
                                <label class="form-label">Status</label>
                                <div class="c-inputs-stacked">
                                    <input name="status" type="radio" id="active" value="1"
                                        {{ $course->status == 1 ? 'checked' : '' }}>
                                    <label for="active" class="me-30">Active</label>
                                    <input name="status" type="radio" id="inactive" value="0"
                                        {{ $course->status == 0 ? 'checked' : '' }}>
                                    <label for="inactive" class="me-30">Inactive</label>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <input type="hidden" name="id" value="{{ $course->id }}">
                            <input type="hidden" name="old_image" value="{{ $course->course_image }}">
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
