<header class="main-header">
    <div class="d-flex align-items-center logo-box justify-content-start">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="logo">
            @php
                if (session()->get('usertype') != 'superadmin') {
                    $user = Auth::user();
                    $schoolid = $user->school_id;
                    $school = App\Models\School::where('id', $schoolid)->first();
                    $logo = 'uploads/school/' . $school->school_logo;
                    $header_name = $school->school_name;
                
                    $display_name = !empty($school->school_logo) ? 'd-none' : '';
                } else {
                    $logo = 'assets/images/logo-valuez.png';
                    $header_name = 'Valuez';
                    $display_name = '';
                }
            @endphp
            <!-- logo-->
            <div class="logo-mini w-60">
                <span class="light-logo"><img src="{{ asset($logo) }}" alt="logo"></span>
            </div>
            <div class="logo-lg {{ $display_name }}">
                {{ $header_name }}
            </div>

        </a>
    </div>
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <div class="app-menu">
            <ul class="header-megamenu nav">
                <li class="btn-group nav-item">
                    <a href="#" class="waves-effect waves-light nav-link push-btn btn-primary-light ms-0"
                        data-toggle="push-menu" role="button">
                        <i data-feather="menu"></i>
                    </a>
                </li>
                <li class="btn-group d-lg-inline-flex d-none">
                    <div class="app-menu">
                        <div class="search-bx mx-5">
                            <form>
                                <div class="input-group">
                                    <input type="search" class="form-control" placeholder="Search">
                                    <div class="input-group-append">
                                        <button class="btn" type="submit" id="button-addon3"><i
                                                class="icon-Search"><span class="path1"></span><span
                                                    class="path2"></span></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <div class="navbar-custom-menu r-side">
            <ul class="nav navbar-nav">
                <li class="btn-group d-md-inline-flex d-none">
                    <a href="javascript:void(0)" title="skin Change" class="waves-effect skin-toggle waves-light">
                        <label class="switch">
                            <input type="checkbox" data-mainsidebarskin="toggle" id="toggle_left_sidebar_skin">
                            <span class="switch-on"><i data-feather="sun"></i></span>
                            <span class="switch-off"><i data-feather="moon"></i></span>
                        </label>
                    </a>
                </li>
                <li class="dropdown notifications-menu btn-group">
                    <a href="#" class="waves-effect waves-light btn-primary-light svg-bt-icon bg-transparent"
                        data-bs-toggle="dropdown" title="Notifications">
                        <i data-feather="bell"></i>
                        <div class="pulse-wave"></div>
                    </a>
                    <ul class="dropdown-menu animated bounceIn">
                        <li class="header">
                            <div class="p-20">
                                <div class="flexbox">
                                    <div>
                                        <h4 class="mb-0 mt-0">Notifications</h4>
                                    </div>
                                    <div>
                                        <a href="#" class="text-danger">Clear All</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu sm-scrol">
                                <li>
                                    <a href="#">
                                        <i class="fa fa-users text-info"></i> Curabitur id eros quis nunc suscipit
                                        blandit.
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-user text-success"></i> Nullam euismod dolor ut quam interdum,
                                        at scelerisque ipsum imperdiet.
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="footer">
                            <a href="#">View all</a>
                        </li>
                    </ul>
                </li>
                @php
                    $user_type = session('usertype') == 'superadmin' ? 'Super Admin' : session('usertype');
                    $fullname = auth()->user()->name;
                @endphp
                <!-- User Account-->
                <li class="dropdown user user-menu">
                    <a href="#"
                        class="waves-effect waves-light dropdown-toggle w-auto l-h-12 bg-transparent p-0 no-shadow"
                        title="User" data-bs-toggle="modal" data-bs-target="#quick_user_toggle">
                        <div class="d-flex pt-1 align-items-center">
                            <div class="text-end me-10">
                                <p class="pt-5 fs-14 mb-0 fw-700">{{ $fullname }}</p>
                                <small class="fs-10 mb-0 text-uppercase text-mute">{{ ucfirst($user_type) }}</small>
                            </div>
                            <img src="{{ asset('assets/images/avatar/avatar-13.png') }}"
                                class="avatar rounded-circle bg-primary-light h-40 w-40" alt="" />
                        </div>
                    </a>
                </li>
                <!-- Control Sidebar Toggle Button -->
                <li class="btn-group nav-item d-xl-inline-flex d-none">
                    <a href="#" data-provide="fullscreen"
                        class="waves-effect waves-light nav-link btn-primary-light svg-bt-icon" title="Full Screen">
                        <i data-feather="maximize"></i>
                    </a>
                </li>

            </ul>
        </div>
    </nav>
</header>

<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar-->
    <section class="sidebar position-relative">
        <div class="multinav">
            <div class="multinav-scroll" style="height: 97%;">
                <!-- sidebar menu-->
                <ul class="sidebar-menu" data-widget="tree">

                    @if (session('usertype') == 'superadmin')
                        <li class="{{ Request::is('admin-dashboard') ? 'active' : '' }}">
                            <a href="{{ route('admin-dashboard') }}"><i
                                    data-feather="home"></i><span>Dashboard</span></a>
                        </li>
                        <li class="{{ Request::is('program/*') ? 'active' : '' }}">
                            <a href="{{ route('program.list') }}"><i
                                    data-feather="list"></i><span>Class/Program</span></a>
                        </li>
                        <li class="{{ Request::is('course/*') ? 'active' : '' }}">
                            <a href="{{ route('course.list') }}"><i data-feather="folder"></i><span>Course</span></a>
                        </li>
                        <li class="{{ Request::is('lesson-plan/*') ? 'active' : '' }}">
                            <a href="{{ route('lesson.plan.list') }}"><i data-feather="calendar"></i><span>Lesson
                                    Plan</span></a>
                        </li>
                        <li class="header">Account</li>
                        <li class="{{ Request::is('school/*') ? 'active' : '' }}">
                            <a href="{{ route('school.list') }}"><i data-feather="grid"></i><span>Manage
                                    School</span></a>
                        </li>
                    @elseif(session('usertype') == 'admin')
                        <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                            <a href="{{ route('dashboard') }}"><i data-feather="home"></i><span>Dashboard</span></a>
                        </li>
                        <li class="{{ Request::is('school/*') ? 'active' : '' }}">
                            <a href="{{ route('school.teacher.list') }}"><i data-feather="user"></i><span>Manage
                                    Teacher</span></a>
                        </li>
                        {{-- <li class="{{ Request::is('school/*') ? 'active' : '' }}">
                            <a href="{{ route('school.teacher.list') }}"><i data-feather="bell"></i><span>What's
                                    new</span></a>
                        </li> --}}
                    @elseif(session('usertype') == 'teacher')
                        <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                            <a href="{{ route('dashboard') }}"><i data-feather="home"></i><span>Dashboard</span></a>
                        </li>
                        <li class="{{ Request::is('teacher/*') ? 'active' : '' }}">
                            <a href="{{ route('teacher.class.list') }}"><i data-feather="list"></i><span>Class
                                    list</span></a>
                        </li>
                    @endif
                    <li>
                        <a href="{{ route('signout') }}"><i data-feather="log-out"></i><span>Logout</span></a>
                    </li>

                </ul>

                <div class="sidebar-widgets">
                    <div class="mx-25 mb-30 pb-20 side-bx bg-primary-light rounded20">
                        <div class="text-center">
                            <img src="{{ asset('assets/images/svg-icon/color-svg/custom-24.svg') }}"
                                class="sideimg p-5" alt="">
                            <h4 class="title-bx text-primary">Best Education Admin</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>
