@extends('layouts.adminapp')
@section('title' , 'Student Attendances')
@section('content')
    <div id="content">
        <nav>
            <div>
                <div class="title2">
                    <div class="row" style="margin:0;">
                        <div class="col-md-5 my-2">
                            <button type="button" id="sidebarCollapse" class="btn stf">
                                <i class="fas fa-align-left"></i> Student_Attendence
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <div class="row search-bar">
            <div class="col-md-6 my-2">
                <input form="search" name="search" type="text" placeholder="Search ..." class="form-control">
            </div>
            <div class="col-md-2 my-2">
                <form id="search" action="" method="get">
                    <button type="submit" class="btn btn-info">Filter</button>
                </form>
            </div>
        </div>
        {{--    @if(session()->has('success'))--}}
        {{--        <p align="center" class="alert alert-success">{{session()->get('success')}}</p>--}}
        {{--    @endif--}}
        {{--    @if(session()->has('error'))--}}
        {{--        <p align="center" class="alert alert-danger">{{session()->get('error')}}</p>--}}
        {{--    @endif--}}

        <table class="tb table table-stuff table-responsive">
            <thead>
            <tr>

                <th>Student_id</th>
                <th>Attendance</th>

            </tr>
            </thead>
            <tbody>
            <tr><td>{{$student_id}}</td>
            </tr>
            </tbody>
        </table>
    </div>

@endsection

