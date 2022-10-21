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
                                <a href="{{ route('lesson.plan.add') }}"
                                    class="waves-effect waves-light btn btn-sm btn-outline btn-info mb-5">Add Lesson Plan</a>
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

                                    @foreach ($lessonplan as $lpdata)
                                        <tr>
                                            <td><img src="{{ url('uploads/lessonplan') }}/{{ $lpdata->lesson_image ? $lpdata->lesson_image : 'no_image.png' }}" width="32"
                                                    height="32" class="bg-light my-n1" alt="{{ $lpdata->title }}">
                                            </td>
                                            <td>{{ $lpdata->title }}</td>
                                            <td>{{ $lpdata->class_id }} </td>
                                            <td>{{ $lpdata->course_id }}</td>
                                            <td>{{ $lpdata->lesson_no }}</td>
                                            <td>{{ $lpdata->video_url }}</td>
                                            <td><span class="badge bg-{{ $lpdata->status == 1 ? 'success' : 'danger' }}">{{ $lpdata->status == 1 ? 'Active' : 'Inactive' }}</span></td>
                                            <td>
                                                <form action="{{ route('lesson.plan.remove', ['lessonplan' => $lpdata->id]) }}" method="POST">
                                                    @csrf
                                                <a href="{{ route('lesson.plan.edit', ['lessonplan' => $lpdata->id]) }}" class="waves-effect waves-light btn btn-sm btn-outline btn-info mb-5">Edit</a>
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
