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
                            <li class="breadcrumb-item active" aria-current="page">Manage Teacher</li>
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
                        <h5 class="card-title mb-0">Manage Teacher</h5>
                        <div class="card-actions float-end">
                            <div class="dropdown show">
                                <a href="{{ route('teacher.add', ['school' => $schoolid]) }}"
                                    class="waves-effect waves-light btn btn-sm btn-outline btn-info mb-5">Add Teacher</a>
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
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-dark">
                                    @foreach ($userlist as $udata)
                                        <tr>
                                            <td>{{ $udata->name }}</td>
                                            <td>{{ $udata->email }}</td>
                                            <td><a href="javascript:void(0);"
                                                    class="change_status text-white badge bg-{{ $udata->status == 1 ? 'success' : 'danger' }}"
                                                    id="status_{{ $udata->id }}" data-id="{{ $udata->id }}"
                                                    data-status="{{ $udata->status }}">{{ $udata->status == 1 ? 'Active' : 'Inactive' }}</a>
                                            </td>
                                            <td>
                                                <form action="{{ route('teacher.remove', ['userid' => $udata->id]) }}"
                                                    method="POST">
                                                    @csrf

                                                    <button class="btn btn-sm btn-outline btn-primary mb-5 dropdown-toggle"
                                                        type="button" data-bs-toggle="dropdown"><i
                                                            class="icon ti-settings"></i>
                                                        Password</button>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="reset_password dropdown-item" href="javascript:void(0);"
                                                            data-userid="{{ $udata->id }}"><i class="fa fa-refresh"></i>
                                                            Reset</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="view_password dropdown-item"
                                                            data-pass="{{ $udata->view_pass }}"
                                                            href="javascript:void(0);"><i class="fa fa-eye"></i> View</a>
                                                    </div>
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

@section('script-section')
    <script>
        $(document).ready(function() {
            $('.view_password').click(function() {
                var viewPass = $(this).attr('data-pass');
                alert("Password : " + viewPass);
            });

            $('.reset_password').click(function() {
                let text;
                if (confirm("Press a ok for Reset Password!") == true) {
                    $.ajax({
                        url: "{{ route('user.password') }}",
                        type: "POST",
                        data: {
                            userid: $(this).attr("data-userid"),
                        },
                        success: function(data) {
                            alert("Your Password Reset");
                            setTimeout(() => {
                                window.location.reload();
                            }, 500);
                        }
                    });
                } else {
                    text = "You canceled!";
                    console.log(text);
                }

            });

            $('.change_status').click(function() {
                var id = $(this).attr('data-id');
                var status = $(this).attr('data-status');
                $.ajax({
                    url: "{{ route('teacher.status') }}",
                    type: "POST",
                    data: {
                        userid: id,
                        status: status
                    },
                    success: function(data) {
                        var csts = (status == 1) ? 0 : 1;
                        $('#status_' + id).text(data).attr('data-status', csts);
                        if (csts == 1) {
                            $('#status_' + id).addClass('bg-success').removeClass('bg-danger');
                        } else {
                            $('#status_' + id).addClass('bg-danger').removeClass('bg-success');
                        }
                    }
                });
            });
        });
    </script>
@endsection
