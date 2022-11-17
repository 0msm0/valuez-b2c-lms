@extends('layout.main')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h4 class="page-title">Lesson Plan</h4>
            </div>

        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    @if ($lessonPlan->first())
                        @foreach ($lessonPlan as $cdata)
                            <div class="col-xl-4 col-md-6 col-12">
                                <div class="blog-post rounded overflow-hidden">
                                    <div class="entry-image clearfix">
                                        @if (filter_var($cdata->video_url, FILTER_VALIDATE_URL) === false)
                                            <img class="img-fluid bg-white"
                                                src="{{ url('uploads/lessonplan') }}/{{ $cdata->lesson_image ? $cdata->lesson_image : 'no_image.png' }}"
                                                alt="{{ $cdata->title }}">
                                        @else
                                            <div class="blog-p-post-you-tube">
                                                <div class="cs-video [youtube, widescreen]">
                                                    <iframe width="560" height="315" src="{{ $cdata->video_url }}"
                                                        frameborder="0" allow="autoplay; encrypted-media"
                                                        allowfullscreen></iframe>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="blog-detail">
                                        <div class="entry-title mb-10">
                                            <a href="#">{{ $cdata->title }}</a>
                                        </div>
                                        <div class="entry-meta mb-10">
                                            <ul class="list-unstyled">
                                                <li><a href="#" class="text-mute hover-primary"><i
                                                            class="fa fa-folder-open-o"></i> Design</a></li>
                                                <li><a href="#" class="text-mute hover-primary"><i
                                                            class="fa fa-comment-o"></i> 5</a></li>
                                                <li><a href="#" class="text-mute hover-primary"><i
                                                            class="fa fa-calendar-o"></i> 12 Aug 2020</a></li>
                                            </ul>
                                        </div>
                                        <div class="entry-content">
                                            <p class="text-gray-600">{{ $cdata->lesson_desc }}</p>
                                        </div>
                                        <div class="entry-share d-flex justify-content-between align-items-center">
                                            <div class="entry-button">
                                                <a href="#" class="btn btn-primary-light btn-sm">Read more</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-sm-6">
                            <div class="card card-body">
                                <h5 class="card-title fw-600">Lesson Plan not found.</h5>
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
