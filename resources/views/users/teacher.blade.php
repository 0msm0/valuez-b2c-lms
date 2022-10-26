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
                            <li class="breadcrumb-item active" aria-current="page">Manage User</li>
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
                        <h5 class="card-title mb-0">Users</h5>
                        <div class="card-actions float-end">
                            <div class="dropdown show">
                                <a href="{{ route('teacher.add', ['school' => $schoolid]) }}"
                                    class="waves-effect waves-light btn btn-sm btn-outline btn-info mb-5">Add User</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example2" class="table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-dark">
                                    @foreach ($userlist as $udata)
                                        <tr>
                                            <td>{{ $udata->name }}</td>
                                            <td>{{ $udata->email }}</td>
                                            <td>
                                                <form action="{{ route('teacher.remove', ['userid' => $udata->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    <a href="{{ route('teacher.edit', ['userid' => $udata->id]) }}"
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
