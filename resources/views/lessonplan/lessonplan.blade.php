
@extends('layout.main')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="d-flex align-items-center">
        <div class="me-auto">
            <h4 class="page-title">Lesson Plan</h4>
            <div class="d-inline-block align-items-center">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Manage Lesson Plan</li>
                    </ol>
                </nav>
            </div>
        </div>

    </div>
</div>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Lesson Plan</h5>
                        <div class="card-actions float-end">
                            <div class="dropdown show">
                                <a href="#" data-bs-toggle="dropdown" data-bs-display="static"><i class="align-middle"
                                        data-feather="more-horizontal"></i></a>

                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example2" class="table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Class Name</th>
                                        <th>Course</th>
                                        <th>Lesson No</th>
                                        <th>Video Link</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-fade">
                                    @for ($i = 0; $i <= 4; $i++)
                                        <tr>
                                            <td><img src="{{ asset('assets/images/avatar/avatar-2.png') }}" width="32"
                                                    height="32" class="bg-light my-n1" alt="Avatar">
                                            </td>
                                            <td>Lesson Plan {{$i+1}}1</td>
                                            <td>Class {{$i+1}}</td>
                                            <td>English</td>
                                            <td>{{$i+1}}</td>
                                            <td>Link</td>
                                            <td><span class="badge bg-success">Active</span></td>
                                            <td><a href="{{ route('school.add') }}" class="waves-effect waves-light btn btn-outline btn-info mb-5">Edit</a>
                                                <button type="button"
                                                    class="waves-effect waves-light btn btn-outline btn-danger mb-5">Delete</button></td>
                                        </tr>
                                        <tr>
                                            <td><img src="{{ asset('assets/images/avatar/avatar-1.png') }}" width="32"
                                                    height="32" class="bg-light rounded-circle my-n1" alt="Avatar">
                                            </td>
                                            <td>Lesson Plan 1{{$i+1}}</td>
                                            <td>Class {{$i+2}}</td>
                                            <td>Hindi</td>
                                            <td>{{$i+2}}</td>
                                            <td>Link</td>
                                            <td><span class="badge bg-danger">Deactive</span></td>
                                            <td><a href="{{ route('school.add') }}" class="waves-effect waves-light btn btn-outline btn-info mb-5">Edit</a>
                                                <button type="button"
                                                    class="waves-effect waves-light btn btn-outline btn-danger mb-5">Delete</button>
                                            </td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- /.content -->
@endsection
