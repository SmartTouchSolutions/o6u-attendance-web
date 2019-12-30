<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/all.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/fontawesome.css')}}">
{{--    <link rel="stylesheet" type="text/css" href="{{asset('/css/bootstrap.css')}}">--}}
    <link rel="stylesheet" type="text/css" href="{{asset('/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{asset('/css/main.css')}}">

</head>
<body>
<div class="wrapper">
    <!-- Sidebar  -->
    @if(! isset($noSidebar))
    <nav id="sidebar">
        <div class="sidebar-header">
            <img src="{{asset('/img/logo2.png')}}" class="img-fluid">
            <strong style="font-size:20px;">O6U</strong>
        </div>

        <ul class="list-unstyled components">
            <li class="active">
                <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <i class="fas fa-user-tie"></i>
                    Professors
                </a>
                <ul class="collapse list-unstyled" id="homeSubmenu">
                    <li>
                        <a href="{{url('/doctor')}}" class="active"> All Professors </a>
                    </li>
                    <li>
                        <a href="#"> Assign Subject </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#teachersubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <i class="fas fa-chalkboard-teacher"></i>
                    Teacher Assistants
                </a>
                <ul class="collapse list-unstyled" id="teachersubmenu">
                    <li>
                        <a href="{{url('/TeacherAssistant')}}"> All Teacher Assistants </a>
                    </li>
                    <li>
                        <a href="#"> Assign Subject </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#studentSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <i class="fas fa-user-graduate"></i>
                    Students
                </a>
                <ul class="collapse list-unstyled" id="studentSubmenu">
                    <li>
                        <a href="student"> All Students </a>
                    </li>
                    <li>
                        <a href="#"> Assign Student </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="subject">
                    <i class="fas fa-copy"></i>
                    Subjects
                </a>
            </li>
        </ul>
    </nav>
    @endif
    @yield('content')

</div>
<script type="text/javascript" src="{{asset('/js/all.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/main.js')}}"></script>

</body>
</html>
