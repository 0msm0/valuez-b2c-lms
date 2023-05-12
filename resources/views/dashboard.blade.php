@extends('layout.main')
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xl-8 col-12">
                <div class="box bg-success">
                    <div class="box-body d-flex p-0">
                        <div class="flex-grow-1 p-30 flex-grow-1 bg-img bg-none-md"
                            style="background-position: right bottom; background-size: auto 100%; background-image: url(../../../images/svg-icon/color-svg/custom-30.svg)">
                            <div class="row">
                                <div class="col-12 col-xl-12">
                                    <h1 class="mb-0 fw-600">Welcome {{ $user->name }},</h1>
                                    <div class="mt-45 d-md-flex align-items-center">
                                        <div class="me-30 mb-30 mb-md-0">
                                            <div class="d-flex align-items-center">
                                                <div
                                                    class="me-15 text-center fs-24 w-50 h-50 l-h-50 bg-danger b-1 border-white rounded-circle">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <div>
                                                    <h5 class="mb-0">Subscription validity</h5>
                                                    <p class="mb-0 text-white-70">
                                                        {{ date('d-m-Y', strtotime($school->package_start)) }} -
                                                        {{ date('d-m-Y', strtotime($school->package_end)) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div>                                           
                                            <div class="d-flex align-items-center">
                                                <div
                                                    class="me-15 text-center fs-24 w-50 h-50 l-h-50 bg-warning b-1 border-white rounded-circle">
                                                    <i class="fa fa-hourglass-half"></i>
                                                </div>
                                                <div>
                                                    <h5 class="mb-0">Time period left for subscription</h5>
                                                    <p class="mb-0 text-white-70">{{$time_left}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-xl-5"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-12">
                <div class="box bg-transparent no-shadow">
                    <div class="box-body p-xl-0 text-center">
                        
                        @if($school->licence == 1)
                    
                        <h3 class="px-30">Make your kids 2023 relevant by accessing Valuez Treasure Chest.</h3>
                        <div>
                            <br>Learn Relevant New-Age Life Valuez
                            <br>Learn Latest AI tools & tech
                            <br>Enjoy Audiobooks
                            <br>Learn Social Manners
                        </div>
                        <a href="{{ route('teacher.add', ['school' => $schoolid]) }}" class="waves-effect waves-light w-p100 btn btn-primary"><i
                                class="fa fa-plus me-15"></i> Add My Kid</a>

                        @else 
                            <h3 class="px-30 mb-10">Explore dashboard to track your kids' journey 
                                <br>Get hands on by reviewing 'parent guidance' and 'conversation topics'.
                            </h3>
                            <a href="{{ route('teacher.list') }}" class="waves-effect waves-light w-p100 btn btn-primary"><i
                                    class="fa fa-plus me-15"></i> Show Dashboard or something</a>
                        
                        @endif

                    </div>
                </div>              
            </div>


            <div class="col-xl-12 col-12">
                <div class="row">
                    <div class="col-xl-4 col-6">
                        <div class="box">
                            <div class="box-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="me-15 bg-primary h-50 w-50 l-h-68 rounded text-center">
                                            <span class="icon-Mail fs-24"></span>
                                        </div>
                                        <div class="d-flex flex-column fw-500">
                                            <a href="course.html" class="text-dark hover-primary mb-1 fs-16">Licences Granted</a>
                                            <span class="text-fade">{{ $school->licence }}</span>
                                        </div>
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                    </div>

                        <div class="col-xl-4 col-6">
                        <div class="box">
                            <div class="box-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="me-15 bg-primary h-50 w-50 l-h-68 rounded text-center">
                                            <span class="icon-Mail fs-24"></span>
                                        </div>
                                        <div class="d-flex flex-column fw-500">
                                            <a href="course.html" class="text-dark hover-primary mb-1 fs-16">Kids Enrolled</a>
                                            <span class="text-fade">{{ $school->teacher->count() }}</span>
                                        </div>
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>


        </div>
    </section>
    <!-- /.content -->
@endsection
