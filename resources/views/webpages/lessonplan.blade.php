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
                                <div class="card">
                                    <img class=""
                                        src="{{ url('uploads/lessonplan') }}/{{ $cdata->lesson_image ? $cdata->lesson_image : 'no_image.png' }}"
                                        alt="{{ $cdata->title }}" />

                                    <div class="card-body">
                                        <h5 class="card-title">{{ $cdata->title }}</h5>

                                        <div class="mb-10">
                                            <ul class="list-unstyled d-flex justify-content-between align-items-center">
                                                <li><a href="#" class="text-mute hover-primary"><i
                                                            class="fa fa-tag"></i>
                                                        {{ $cdata->program->class_name }}</a></li>
                                                <li><a href="#" class="text-mute hover-primary"><i
                                                            class="fa fa-folder-open-o"></i>
                                                        {{ $cdata->course->course_name }}</a></li>
                                            </ul>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center">
                                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#bs-info-modal-{{ $cdata->id }}">Read
                                                Instructions</button>

                                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#bs-video-modal-{{ $cdata->id }}">View Video</button>

                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- Video modal -->
                            <div class="modal fade" id="bs-video-modal-{{ $cdata->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="modal-label-{{ $cdata->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-hidden="true"></button>
                                        </div>
                                        <div class="modal-body pt-0">
                                            {{-- {{ $cdata->video_url }} --}}
                                            @php
                                                $parsed = parse_url($cdata->video_url);
                                                $checkUrlHost = explode('.', $parsed['host']);
                                                if (in_array('youtube', $checkUrlHost)) {
                                                    $video_id = explode('?v=', $cdata->video_url);
                                                    if (empty($video_id[1])) {
                                                        $video_id = explode('/v/', $cdata->video_url);
                                                    }
                                                    $video_id = explode('&', $video_id[1]);
                                                    $video_id = $video_id[0];
                                                    $video_url = 'https://www.youtube.com/embed/' . $video_id;

                                                } elseif (in_array('vimeo', $checkUrlHost)) {
                                                    $video_id = (int) substr(parse_url($cdata->video_url, PHP_URL_PATH), 1);
                                                    $video_url = 'https://player.vimeo.com/video/'.$video_id;
                                                } else {
                                                    $video_url = '';
                                                }
                                            @endphp
                                            <iframe src="{{ $video_url }}"
                                                style="overflow:hidden;height:350px;width: 100%;" frameborder="0"
                                                allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>


                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->

                            <!-- Info modal -->
                            <div class="modal fade" id="bs-info-modal-{{ $cdata->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="modal-label-{{ $cdata->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="modal-label--{{ $cdata->id }}">
                                                {{ $cdata->title }}</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-hidden="true"></button>
                                        </div>
                                        <div class="modal-body">
                                            {{ $cdata->lesson_desc }}
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
@endsection

<script language="javascript" type="text/javascript">
    $(function() {
        $('.btn-close').click(function() {
            $('iframe').attr('src', $('iframe').attr('src'));
        });
    });
</script>
