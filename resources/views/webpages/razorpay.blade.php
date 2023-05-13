@extends('layout.main')
@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h4 class="page-title">Users</h4>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page">Manage Kids Accounts</li>
                            <li class="breadcrumb-item active" aria-current="page">Kid Add</li>
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
                        <h4 class="box-title">Payment By Razorpay</h4>
                    </div>

                    <div class="card card-default">
                        <div class="card-header">
                            Laravel - Razorpay Payment Gateway Integration
                        </div>
                        <div class="card-body text-center">
                            <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
                            <form action="{{ route('razorpay.payment.store') }}" method="POST" >
                                @csrf 
                                <script src="https://checkout.razorpay.com/v1/checkout.js"
                                        data-key="{{ env('RAZORPAY_LIVE_KEY_ID') }}"
                                        data-amount="{{ $amount * 100 }}"
                                        data-currency="{{ $currency }}"
                                        data-order_id="{{ $orderId }}"
                                        data-buttontext="Pay Now"
                                        data-name="Valuez Treasure Chest - 1 yr subscription"
                                        data-description="Razorpay payment"
                                        data-image="/images/logo-icon.png"
                                        data-prefill.name={{ Auth::user()->name }}
                                        data-prefill.email={{ Auth::user()->name }}
                                        data-theme.color="#ff7529">
                                </script>
                                <input type="hidden" custom="Hidden Element" name="hidden">
                                @csrf
                            </form>
                        </div>
                    </div>


                </div>
                <!-- /.box -->
            </div>

        </div>
    </section>
    <!-- /.content -->
@endsection
