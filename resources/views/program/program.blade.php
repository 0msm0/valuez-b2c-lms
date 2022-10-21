
@extends('layout.main')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="d-flex align-items-center">
        <div class="me-auto">
            <h4 class="page-title">Class / Program</h4>
            <div class="d-inline-block align-items-center">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Manage Class / Program</li>
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
                    <h5 class="card-title mb-0">Class / Program</h5>
                    <div class="card-actions float-end">
                        <div class="dropdown show">
                            <a href="{{ route('program.add') }}"
                                class="waves-effect waves-light btn btn-sm btn-outline btn-info mb-5">Add Program</a>
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
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-fade">
                                @foreach ($class_list as $cdata)
                                <tr>
                                    <td><img src="{{ url('uploads/program') }}/{{ $cdata->class_image ? $cdata->class_image : 'no_image.png' }}"
                                            width="32" height="32" class="bg-light my-n1"
                                            alt="{{ $cdata->class_name }}">
                                    </td>
                                    <td>{{ $cdata->class_name }}</td>
                                    <td><span
                                            class="badge bg-{{ $cdata->status == 1 ? 'success' : 'danger' }}">{{ $cdata->status == 1 ? 'Active' : 'Inactive' }}</span>
                                    </td>
                                    <td>
                                        <form action="{{ route('program.remove', ['program' => $cdata->id]) }}" method="POST">
                                            @csrf
                                            <a href="{{ route('program.edit', ['program' => $cdata->id]) }}" class="waves-effect waves-light btn btn-sm btn-outline btn-info mb-5">Edit</a>
                                            <button type="submit" class="waves-effect waves-light btn btn-sm btn-outline btn-danger mb-5">Delete</button>
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
