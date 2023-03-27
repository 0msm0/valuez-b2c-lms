@extends('layout.main')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h4 class="page-title">School Registration</h4>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('school.list') }}">Manage
                                    School</a></li>
                            <li class="breadcrumb-item active" aria-current="page">School Registration</li>
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
                        <h4 class="box-title">Add New School</h4>
                    </div>
                    <!-- /.box-header -->
                    <form action="{{ route('school.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="box-body">
                            <h4 class="box-title text-primary mb-0"><i class="ti-view-grid me-15"></i> School Info</h4>
                            <hr class="my-15">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">School Name <span class="text-danger">*</span></label>
                                        <input type="text" value="{{ old('title') }}" name="title" class="form-control"
                                            placeholder="Enter School Name">
                                        @error('title')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">School Mobile <span class="text-danger">*</span></label>
                                        <input type="text" value="{{ old('mobile') }}" name="mobile" class="form-control"
                                            placeholder="Enter School Mobile">
                                        @error('mobile')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">School Address <span class="text-danger">*</span></label>
                                        <input type="text" value="{{ old('address') }}" name="address" class="form-control"
                                            placeholder="Enter School Address">
                                        @error('address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">School Logo <span class="text-danger">*</span></label>
                                        <input type="file" name="school_logo" class="form-control">
                                        @error('school_logo')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">School Remarks</label>
                                        <textarea name="school_desc" class="form-control" placeholder="Enter School specific details">{{ old('school_desc') }}</textarea>
                                        @error('school_desc')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Subscription Start date <span
                                                class="text-danger">*</span></label>
                                        <input type="date" value="{{ old('package_start') }}" min='{{ date('Y-m-d', strtotime("-12 month")) }}' name="package_start"
                                            class="form-control" placeholder="Enter Subscription Start date">
                                        @error('package_start')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Subscription end date <span
                                                class="text-danger">*</span></label>
                                        <input type="date" value="{{ old('package_end') }}" min='{{ date('Y-m-d') }}' name="package_end"
                                            class="form-control" placeholder="Subscription end date">
                                        @error('package_end')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Total Licence <span class="text-danger">*</span></label>
                                        <input type="number" value="25" name="licence" class="form-control"
                                            placeholder="Enter Total Licence">
                                        @error('licence')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Grade</label>
                                        <select class="form-control" name="grade_ids[]" style="width: 100%;"
                                            id="grade_ids" multiple="multiple">
                                            <option value="">Select Grade</option>
                                            @foreach ($grades as $grade)
                                                @php $gradeIds = old('grade_ids'); @endphp
                                                <option value="{{ $grade->id }}"
                                                    {{ !empty($gradeIds) && in_array($grade->id, $gradeIds) ? 'selected' : '' }}>
                                                    {{ $grade->class_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('grade_ids')
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
                                        <input type="text" name="primary_person" value="{{ old('primary_person') }}" class="form-control"
                                            placeholder="Enter Person Name">
                                        @error('primary_person')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Primary Email <span class="text-danger">*</span></label>
                                        <input type="email" name="primary_email" value="{{ old('primary_email') }}" class="form-control"
                                            placeholder="Enter Primary Email">
                                        @error('primary_email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Primary Mobile <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="primary_mobile" value="{{ old('primary_mobile') }}" class="form-control"
                                            placeholder="Enter Primary Mobile">
                                        @error('primary_mobile')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Secondary Email </label>
                                        <input type="email" name="secondary_email" value="{{ old('secondary_email') }}" class="form-control"
                                            placeholder="Enter Secondary Email">
                                        @error('secondary_email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Secondary Mobile </label>
                                        <input type="text" name="secondary_mobile" value="{{ old('secondary_mobile') }}" class="form-control"
                                            placeholder="Enter Secondary Mobile">
                                        @error('secondary_mobile')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <hr class="my-15">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">State</label>
                                        <select class="form-control select2" name="state_id" style="width: 100%;"
                                            id="state_id">
                                            <option value="">Select State</option>
                                            @foreach ($states as $state)
                                                @php $stateIds = old('state_id'); @endphp
                                                <option value="{{ $state->id }}"
                                                    {{ !empty($stateIds) && ($state->id == $stateIds) ? 'selected' : '' }}>
                                                    {{ $state->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('state_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">City</label>
                                        <select class="form-control select2" name="city_id" style="width: 100%;"
                                            id="city_id">
                                            <option value="">Select City</option>
                                        </select>
                                        @error('city_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Pincode <span class="text-danger">*</span></label>
                                        <input type="text" name="pincode" class="form-control"
                                            placeholder="Enter Pincode">
                                        @error('pincode')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <hr>
                            <div class="form-group">
                                <label class="form-label">Status</label>
                                <div class="c-inputs-stacked">
                                    <input name="status" type="radio" id="active" value="1" checked>
                                    <label for="active" class="me-30">Active</label>
                                    <input name="status" type="radio" id="inactive" value="0">
                                    <label for="inactive" class="me-30">Inactive</label>
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

@section('script-section')
    <script>
        $(document).ready(function() {

            $('.select2').select2();
            $('#grade_ids').select2({
                tags:true
            });
            $('#state_id').on('change', function() {
                var idState = this.value;
                $("#city_id").html('');
                $.ajax({
                    url: "{{ route('city.json') }}",
                    type: "POST",
                    data: {
                        state_id: idState,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(res) {
                        $('#city_id').html('<option value="">Select City</option>');
                        $.each(res.cities, function(key, value) {
                            $("#city_id").append('<option value="' + value
                                .id + '">' + value.city + '</option>');
                        });
                    }
                });
            });
        });
    </script>
@endsection
