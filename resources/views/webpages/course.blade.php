@extends('layout.main')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h4 class="page-title">Course</h4>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><i class="mdi mdi-home-outline"></i></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('teacher.class.list') }}">Grade</a></li>                           
                            <li class="breadcrumb-item active" aria-current="page">Course</li>
                        </ol>
                    </nav>
                </div>
            </div>

        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    @if ($course->first())
                        @foreach ($course as $cdata)
                            <div class="col-xl-4 col-md-6 col-12">
                                <div class="box">
                                    <div class="box-body">
                                        <div class="overlay position-relative">
                                            <img src="{{ url('uploads/course') }}/{{ $cdata->course_image ? $cdata->course_image : 'no_image.png' }}"
                                                alt="" class="img-fluid">
                                        </div>
                                        <div class="mt-30 pro-dec text-center">
                                            <h5 class="fw-500"><a href="#">{{ $cdata->course_name }}</a></h5>
                                            <div class="price-dle d-flex justify-content-center align-items-center">
                                                <a href="{{ route('teacher.lesson.list', ['classid' => $classId,'course'=> $cdata->course_id]) }}"
                                                    class="btn btn-sm btn-primary me-2">View Instruction Modules</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                    <div class="col-sm-6">
                        <div class="card card-body">
                            <h5 class="card-title fw-600">Course not found.</h5>
                            <a href="{{ route('teacher.class.list') }}" class="btn btn-primary-light">Go Back</a>
                        </div> <!-- end card-->
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
