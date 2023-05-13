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
                        <h4 class="box-title">Valuez Treasure Chest - 1 Yr License Subscription</h4>
                    </div>

                    <div class="card card-default">
                        <div class="card-header">
                            Laravel - Razorpay Payment Gateway Integration
                        </div>
                        <div class="card-body text-center">
                            
                            <form action="{{ url('payment') }}" method="post" id="addPaymentForm">
                                @csrf
                                <div class="popupForm">
                                    <div class="popupHeading">
                                        <h2>Payment</h2>
                                    </div>
                                    <div class="form-group floating-field">
                                        <input type="hidden" name="razorpay_payment_id" value="" id="razorpay_payment_id">
                                        <input type="hidden" name="razorpay_order_id" value="" id="razorpay_order_id">
                                        <input type="hidden" name="razorpay_signature" value="" id="razorpay_signature">
                                        <input type="hidden" name="generated_signature" value="" id="generated_signature">
                                        <input type="text" name="amount" value="" id="payment">

                                </div><!--//popupForm-->

                                        <div class="col-sm-6 text-right">                                 
                                            <button class="btn btn-primary" type="button" id="addPaymentButton">Submit</button>
                                        </div>

                                </div>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script>

$('#addPaymentButton').on('click', function (e) {
    console.log('asd');
    e.preventDefault();
    var amount = $('#payment').val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: "post",
        url: "orderid-generate",
        data: $("#addPaymentForm").serialize(),
        success: function (data) {
            var order_id = '';
            if (data.order_id) {
                order_id = data.order_id;
            }

            var options = {
                "key": "{{ config('app.razorpay_api_key') }}", // Enter the Key ID generated from the Dashboard
                "amount": amount, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
                "currency": "{{ config('app.currency') }}",
                "name": "{{ config('app.account_name') }}",
                "description": remarks,
                "image": "{{ asset('images/logo-black.svg') }}",
                "order_id": order_id, //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
                "handler": function (response) {
                    $('#razorpay_payment_id').val(response.razorpay_payment_id);
                    $('#razorpay_order_id').val(response.razorpay_order_id);
                    $('#razorpay_signature').val(response.razorpay_signature);
                    $('#addPaymentForm').submit();
                },
                "prefill": {
                    "name": "{{ auth()->user()->name }}",
                    "email": "{{ auth()->user()->email }}",
                    "contact": "{{ auth()->user()->mobile }}"
                },
        "notes": {
            "address": "Razorpay Corporate Office"
        },
                "theme": {
                    "color": "#3399cc"
                }
            };
            var rzp1 = new Razorpay(options);
            rzp1.on('payment.failed', function (response) {

            });

            rzp1.open();


        },

    });

});
</script>