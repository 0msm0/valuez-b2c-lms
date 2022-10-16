
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
                        <li class="breadcrumb-item" aria-current="page">Manage Program</li>
                        <li class="breadcrumb-item active" aria-current="page">Program Edit</li>
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
                        <h4 class="box-title">Update Program</h4>
                    </div>
                    <!-- /.box-header -->
                    <form>
                        <div class="box-body">                          
                            <div class="form-group">
                                <label class="form-label">Program Title</label>
                                <input type="email" class="form-control" placeholder="Enter Program Title">
                            </div>
                            <div class="form-group">
                                <label for="formFile" class="form-label">Program Image</label>
                                <input class="form-control" type="file" id="formFile">
                            </div>                         
                            <hr>
                            <div class="form-group">
                                <label class="form-label">Status</label>
                                <div class="c-inputs-stacked">
                                    <input name="status" type="radio" id="radio_123" value="1" checked>
                                    <label for="radio_123" class="me-30">Active</label>                           
                                    <input name="status" type="radio" id="radio_789" value="0">
                                    <label for="radio_789" class="me-30">Inactive</label>
                                </div>
                            </div>                          
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
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
