<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    {{--@if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif--}}
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('library.index') }}">
                            <b>{{ __('Library books') }}</b>
                        </a>
                    </li>
                    <li class="nav-item">
                        @if(auth()->user()->hasRole('Administrator'))
                            <a class="nav-link" href="{{ route('attendance.index') }}">
                                <b>{{ __('Class Attendance') }}</b>
                            </a>
                        @endif
                        @if(auth()->user()->hasRole('Teacher'))
                            <a class="nav-link" href="{{ route('attendance.create') }}">
                                <b>{{ __('Class Attendance') }}</b>
                            </a>
                        @endif
                    </li>

                    @if(auth()->user()->hasRole('Administrator'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('teacher.index') }}">
                            <b>{{ __('All Teacher') }}</b>
                        </a>
                    </li>
                    @endif
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <b>{{ __('Student') }}</b>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('student.index') }}">
                                All Students
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('home-task.index') }}">
                                Home Tasks
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('student-progress.index') }}">
                                Academic Progress
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('syllabus.index') }}">
                                {{ __('Syllabus') }}
                            </a>
                        </div>
                    </li>
                    @if(auth()->user()->hasRole('Administrator'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('role.index') }}">
                                <b>{{ __('Roles') }}</b>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('academic-result.index') }}">
                                <b>{{ __('Academic Result') }}</b>
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('routine.index') }}">
                            <b>{{ __('Class Routine') }}</b>
                        </a>
                    </li>
                    @if(auth()->user()->hasRole('Administrator'))
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <b>{{ __('Configurations') }}</b>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('subject.index') }}">
                                All Subjects
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('student-class.index') }}">
                                All Classes
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('designation.index') }}">
                                Designations
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('school.index') }}">
                                List of Schools
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('shift.index') }}">
                                All Shifts
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('section.index') }}">
                                All Sections
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('notice.index') }}">
                                All Notice
                            </a>
                        </div>
                    </li>
                    @endif
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <b>{{ Auth::user()->name }}</b>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('profile.index') }}">
                                Profile
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
