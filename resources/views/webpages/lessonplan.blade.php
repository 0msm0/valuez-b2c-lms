@extends('layout.main')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h4 class="page-title">Instruction Module</h4>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><i class="mdi mdi-home-outline"></i></li>
                            <li class="breadcrumb-item" aria-current="page"><a
                                    href="{{ route('teacher.class.list') }}">{{ $class_name->class_name; }}</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a
                                    href="{{ route('teacher.course.list', ['class' => $class_id]) }}">Course</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Instruction Module</li>
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
                    @if ($lessonPlan->first())
                        @foreach ($lessonPlan as $cdata)
                            @php
                                if (($cdata->is_demo == 1 && $check_premium->is_demo == 1) || $check_premium->is_demo == 0) {
                                    $is_demo_content = 1;
                                    $main_video = !empty($cdata->video_url) ? App\Http\Controllers\WebPage::getVideoUrl($cdata->video_url) : '';
                                    $info_video = !empty($cdata->video_info_url) ? App\Http\Controllers\WebPage::getVideoUrl($cdata->video_info_url) : '';
                                } else {
                                    $main_video = $info_video = $is_demo_content = '#';
                                }
                            @endphp
                            <div class="col-xl-4 col-md-6 col-12 px-4">
                                <div class="card">
                                    @if ($is_demo_content == '#')
                                        <div class="position-absolute r-0"><button type="button"
                                                class="waves-effect waves-circle btn btn-circle btn-info btn-md mb-5"
                                                data-bs-toggle="modal" data-bs-target="#bs-video-modal-demo"><i
                                                    class="mdi mdi-lock fs-2"></i></button></div>
                                    @endif
                                    <img class="video-btn"
                                        src="{{ url('uploads/lessonplan') }}/{{ $cdata->lesson_image ? $cdata->lesson_image : 'no_image.png' }}"
                                        alt="{{ $cdata->title }}" data-title="{{ $cdata->title }}" data-bs-toggle="modal"
                                        data-src="{{ $main_video }}"
                                        data-bs-target="#bs-video-modal{{ $main_video == '#' ? '-demo' : '' }}" />

                                    <div class="card-body">
                                        <h5 class="card-title">{{ $cdata->title }}</h5>
                                        <div class="mb-10">
                                            <ul class="list-unstyled d-flex justify-content-between align-items-center">
                                                <li><a href="#" class="text-mute hover-primary"><i
                                                            class="fa fa-tag"></i>
                                                        {{ @$class_name->class_name }}</a></li>
                                                <li><a href="#" class="text-mute hover-primary"><i
                                                            class="fa fa-folder-open-o"></i>
                                                        {{ $cdata->course->course_name }}</a></li>
                                            </ul>
                                        </div>
                                        @if (($cdata->is_demo == 1 && $check_premium->is_demo == 1) || $check_premium->is_demo == 0)
                                            <div class="justify-content-center align-items-center">
                                                @if ($cdata->lesson_desc)
                                                    <button type="button" class="btn btn-info btn-sm mb-5"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#bs-info-modal-{{ $cdata->id }}">Read
                                                        Instructions</button>
                                                @endif

                                                @if ($cdata->video_info_url)
                                                    <button id="vid-btn-{{ $cdata->id }}"
                                                        data-src="{{ $info_video }}" data-title="{{ $cdata->title }}"
                                                        type="button" class="video-btn btn btn-warning btn-sm mb-5"
                                                        data-bs-toggle="modal" data-bs-target="#bs-video-modal">Instructions
                                                        Video</button>
                                                    {{-- <a class="popup-youtube btn btn-primary" href="{{ $video_url }}">Open
                                                    YouTube video</a> --}}
                                                @endif

                                                <button id="read-btn-{{ $cdata->id }}" data-grade="{{ $class_id }}"
                                                    data-id="{{ $cdata->id }}" type="button"
                                                    class="btn btn-{{ in_array($cdata->id, $complete_lesson) ? 'success' : 'dark mark-as-read' }} btn-sm">{{ in_array($cdata->id, $complete_lesson)
                                                        ? 'Completed'
                                                        : 'Mark
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        as
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        complete' }}</button>

                                            </div>
                                        @else
                                            <div class="card-footer justify-content-between d-flex px-0 pb-0">

                                                <ul class="list-inline mb-0">
                                                    <li><button class="btn btn-warning btn-sm mb-5" data-bs-toggle="modal"
                                                            data-bs-target="#bs-video-modal-demo">Buy
                                                            Subscription</button></li>
                                                </ul>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </div>

                            <!-- Info modal -->
                            <div class="modal fade" id="bs-info-modal-{{ $cdata->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="modal-label-{{ $cdata->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="modal-label-{{ $cdata->id }}">
                                                {{ $cdata->title }}</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-hidden="true"></button>
                                        </div>
                                        <div class="modal-body">
                                            {!! $cdata->lesson_desc !!}
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->
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


    <!-- Info modal -->
    <div class="modal fade" id="bs-video-modal-demo" tabindex="-1" role="dialog" aria-labelledby="modal-label-demo"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-label-">Alert</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <p>Hello <b id="school_name"></b>,</p>

                    <p>The academic year subscription of our "Near Future Technologies + NEP Values education package for
                        21st
                        Century school" gives you access to following:</p><br />

                    <p>- Near Future Tech knowledge in easy, fun way (50+ modules)</p>
                    <p>- Future Ready Bulletins (56 bulletins & more every 2 weeks)</p>
                    <p>- NEP Values modules (Grade Nursery to 5)</p><br />

                    <p>Easy teacher guidance with each module, and can seamlessly blend into your curriculum.</p><br />

                    <p>Contact your school admin or write to <b>support@valuezhut.com</b> for a full subscription.</p>

                    <p>Your partner in 21st century learner journey,<br />
                        Valuez: Conversations Matter</p>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- Main Video Modal -->
    <div class="modal fade" id="bs-video-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="ribbon-box video-close">
                    <div class="ribbon ribbon-danger float-end btn-close1" data-bs-dismiss="modal" aria-label="Close"
                        style="cursor: pointer;">
                        <i class="mdi mdi-close"></i>
                    </div>
                    <h5 class="text-danger float-start m-0 p-3" id="video-title">Video Player</h5>
                </div>
                <div class="modal-body pt-0">
                    <div id="video-loader" class="text-center"><i class="fa fa-spinner fa-spin fs-1"></i></div>
                    <!-- 16:9 aspect ratio -->
                    <div class="ratio ratio-16x9">
                        <iframe class="embed-responsive-item" frameborder="0" src="" id="video"
                            allowscriptaccess="always" allow="autoplay" webkitallowfullscreen mozallowfullscreen
                            allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script-section')
    <script language="javascript" type="text/javascript">
        $(function() {
            var school_name = $("#get_schoolname").text();
            $("#school_name").html(school_name);
            $('.mark-as-read').click(function() {
                var videoId = $(this).attr('data-id');
                var classId = $(this).attr('data-grade');
                swal({
                    title: "Are you sure?",
                    text: "This is one way action. Click Yes only after teaching this module in the class",
                    // type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#fec801",
                    confirmButtonText: "Yes",
                    cancelButtonText: "Cancel",
                    closeOnConfirm: false,
                    closeOnCancel: true
                }, function(isConfirm) {
                    if (isConfirm) {
                      
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('report.save.plan') }}",
                            data: {
                                planId: videoId,
                                gradeId: classId,
                            },
                            beforeSend: function() {
                                $('#read-btn-' + videoId).html("Please wait..");
                            },
                            success: function(data) {
                                console.log(data);
                                if (data == 'update') {
                                    $('#read-btn-' + videoId).html("Completed")
                                        .addClass("btn-success")
                                        .removeClass("btn-dark");
                                    swal("Completed!",
                                        "Your Module has been marked as completed.",
                                        "success");
                                } else {
                                    console.log(data);
                                    $('#read-btn-' + videoId).html("Error");
                                }
                            }
                        });

                    }
                });
            });

        });

        $(document).ready(function() {
            // Gets the video src from the data-src on each button
            var $videoSrc;
            $('.video-btn').click(function() {
                $videoSrc = $(this).data("src");
                $("#video-title").text($(this).data("title"));
                $("#video-loader").show();
            });
            // console.log($videoSrc);
            $('#bs-video-modal').on('shown.bs.modal', function(e) {
                setTimeout(() => {
                    $("#video").attr('src', $videoSrc);
                    $("#video-loader").hide();
                }, 200);
            })
            $('#bs-video-modal').on('hide.bs.modal', function(e) {
                $("#video").attr('src', "");
            })
            // document ready
        });
    </script>
@endsection
<style>
    #bs-video-modal .modal-dialog {
        max-width: 800px;
        margin: 30px auto;
    }

    #bs-video-modal .modal-body {
        position: relative;
        padding: 5px;
    }

    @media (max-width: 765px) {
        .video-close .ribbon.float-end {
            margin-right: 0px !important;
            padding: 5px;
        }
    }
</style>
