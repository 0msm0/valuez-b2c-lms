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
                            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('school.list') }}">Manage School</a></li>
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
            <div class="col-lg-12 col-12">
                <!-- Basic Forms -->
                <div class="box">
                    <div class="box-header with-border">
                        <h4 class="box-title">Update School</h4>
                    </div>
                    <!-- /.box-header -->
                    <form action="{{ route('school.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="box-body">

                            <h4 class="box-title text-primary mb-0"><i class="ti-view-grid me-15"></i> School Info</h4>
                            <hr class="my-15">
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label class="form-label">School Name <span class="text-danger">*</span></label>
                                        <input type="text" name="title" value="{{ $school->school_name }}"
                                            class="form-control" placeholder="Enter School Name">
                                        @error('title')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">School Mobile <span class="text-danger">*</span></label>
                                        <input type="text" name="mobile" value="{{ $school->mobile }}"
                                            class="form-control" placeholder="Enter School Mobile">
                                        @error('mobile')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">School Address <span class="text-danger">*</span></label>
                                        <input type="text" name="address" value="{{ $school->address }}"
                                            class="form-control" placeholder="Enter School Address">
                                        @error('address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Total Licence <span class="text-danger">*</span></label>
                                        <input type="text" name="licence" value="{{ $school->licence }}"
                                            class="form-control" placeholder="Enter Total licence">
                                        @error('licence')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <h4 class="box-title text-primary mb-0 mt-20"><i class="ti-envelope me-15"></i> Contact Info
                            </h4>
                            <hr class="my-15">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Primary Person Name<span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="primary_person" value="{{ $school->primary_person }}"
                                            class="form-control" placeholder="Enter Person Name">
                                        @error('primary_person')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Primary Email <span class="text-danger">*</span></label>
                                        <input type="text" name="primary_email" value="{{ $school->primary_email }}"
                                            class="form-control" placeholder="Enter Primary Email">
                                        @error('primary_email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Primary Mobile <span class="text-danger">*</span></label>
                                        <input type="text" name="primary_mobile" value="{{ $school->primary_mobile }}"
                                            class="form-control" placeholder="Enter Primary Mobile">
                                        @error('primary_mobile')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <div class="form-group">
                                <label class="form-label">Status</label>
                                <div class="c-inputs-stacked">
                                    <input name="status" type="radio" id="active" value="1"
                                        {{ $school->status == 1 ? 'checked' : '' }}>
                                    <label for="active" class="me-30">Active</label>
                                    <input name="status" type="radio" id="inactive" value="0"
                                        {{ $school->status == 0 ? 'checked' : '' }}>
                                    <label for="inactive" class="me-30">Inactive</label>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <input type="hidden" name="id" value="{{ $school->id }}">
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
