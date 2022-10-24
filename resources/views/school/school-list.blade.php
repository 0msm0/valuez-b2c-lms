@extends('layout.main')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h4 class="page-title">Manage School</h4>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Manage School</li>
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
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        {{ $message }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">School</h5>
                        <div class="card-actions float-end">
                            <div class="dropdown show">
                                <a href="{{ route('school.add') }}"
                                    class="waves-effect waves-light btn btn-sm btn-outline btn-info mb-5">Add School</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example2" class="table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>School</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Contact</th>
                                        <th>Teacher</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-fade">
                                    @foreach ($school as $sdata)
                                        <tr>
                                            <td><img src="{{ asset('assets/images/avatar/avatar-2.png') }}" width="32"
                                                    height="32" class="bg-light rounded-circle my-n1" alt="Avatar">
                                            </td>
                                            <td>{{ $sdata->school_name }}</td>
                                            <td>{{ $sdata->primary_person }}</td>
                                            <td>{{ $sdata->primary_email }}</td>
                                            <td>{{ $sdata->primary_mobile }}</td>
                                            <td>{{ $sdata->licence }}</td>
                                            <td><span class="badge bg-{{ $sdata->status == 1 ? 'success' : 'danger' }}">{{ $sdata->status == 1 ? 'Active' : 'Inactive' }}</span>
                                            </td>
                                            <td>
                                                <form action="{{ route('school.remove', ['school' => $sdata->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    <a href="{{ route('school.edit', ['school' => $sdata->id]) }}"
                                                        class="waves-effect waves-light btn btn-sm btn-outline btn-info mb-5">Edit</a>
                                                    <button type="submit"
                                                        class="waves-effect waves-light btn btn-sm btn-outline btn-danger mb-5">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
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
