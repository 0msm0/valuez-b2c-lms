@extends('layout.main')
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xl-9 col-12">
                <div class="box bg-success">
                    <div class="box-body d-flex p-0">
                        <div class="flex-grow-1 p-30 flex-grow-1 bg-img bg-none-md"
                            style="background-position: right bottom; background-size: auto 100%; background-image: url(../../../images/svg-icon/color-svg/custom-30.svg)">
                            <div class="row">
                                <div class="col-12 col-xl-12">
                                    <h1 class="mb-0 fw-600">NEP compliant Values and Near-Future-Tech courses</h1>
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
        </div>
    </section>
    <!-- /.content -->
@endsection
