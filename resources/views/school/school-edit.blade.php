@extends('layout.main')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="d-flex align-items-center">
        <div class="me-auto">
            <h4 class="page-title">Update School</h4>
            <div class="d-inline-block align-items-center">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                        <li class="breadcrumb-item" aria-current="page">Manage School</li>
                        <li class="breadcrumb-item active" aria-current="page">Update School</li>
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
                        <h4 class="box-title">Form Sections</h4>
                    </div>
                    <!-- /.box-header -->
                    <form>
                        <div class="box-body">                          
                            <div class="form-group">
                                <label class="form-label">Full Name:</label>
                                <input type="email" class="form-control" placeholder="Enter full name">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Email address:</label>
                                <input type="email" class="form-control" placeholder="Enter email">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Contact:</label>
                                <input type="tel" class="form-control" placeholder="Phone number">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Communications :</label>
                                <div class="c-inputs-stacked">
                                    <input type="checkbox" id="checkbox_123">
                                    <label for="checkbox_123" class="me-30">Email</label>
                                    <input type="checkbox" id="checkbox_234">
                                    <label for="checkbox_234" class="me-30">SMS</label>
                                    <input type="checkbox" id="checkbox_345">
                                    <label for="checkbox_345" class="me-30">Phone</label>
                                </div>
                            </div>
                            <hr>

                            <h4 class="mt-0 mb-20">2. Payment Info:</h4>

                            <div class="form-group">
                                <label class="form-label">Payment Method :</label>
                                <div class="c-inputs-stacked">
                                    <input name="group123" type="radio" id="radio_123" value="1">
                                    <label for="radio_123" class="me-30">Credit Card</label>
                                    <input name="group456" type="radio" id="radio_456" value="1">
                                    <label for="radio_456" class="me-30">Cash</label>
                                    <input name="group789" type="radio" id="radio_789" value="1">
                                    <label for="radio_789" class="me-30">Wallet</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Amount:</label>
                                <input type="email" class="form-control" placeholder="Enter full name">
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-danger">Cancel</button>
                            <button type="submit" class="btn btn-success pull-right">Submit</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>

        </div>
    </section>
    <!-- /.content -->
@endsection
