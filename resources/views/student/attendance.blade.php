@extends('layouts.adminapp')
@section('content')
@php $noSidebar=''; @endphp

<div id="content">
    <nav>
        <div>
            <div class="title2">
                <div class="row" style="margin:0;">
                    <div class="col-md-10 my-2">
                        <button type="button" id="sidebarCollapse" class="btn stf">
                            <i class="fas fa-align-left"></i> Student Attendance
                        </button>
                    </div>
                    <div class="col-md-2 my-2">
                    <a style="font-weight: bold;color: black;" href="{{route('logoutStudent')}}">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <p align="center">StudentName :@if(count($studentAttendance) > 0) {{$studentAttendance[0]['student_attendance']['username']}} @else (count($studentWithNoAttendance) > 0) {{$studentWithNoAttendance[0]['username']}}  @endif </p>
    <p align="center">StudentCode :@if(count($studentAttendance) > 0) {{$studentAttendance[0]['student_attendance']['student_code']}} @else (count($studentWithNoAttendance) > 0) {{$studentWithNoAttendance[0]['student_code']}}   @endif</p>
    <table class="tb table table-stuff table-responsive">
        <thead>
        <tr>
            {{-- /*/*<th style="width:140px;">UserName</th>*/*/ --}}
            {{-- <th>Student_Code</th> --}}
            <th>Subject</th>
            <th>Count Of Attendance</th>
            <th>Count Of Absent</th>
            <th>Count Of Lectures</th>

        </tr>
        </thead>
        <tbody>
        @if(count($studentAttendance) > 0)    
        @foreach($studentAttendance as $student)
        {{-- {{dd($student)}} --}}
            <tr>
                {{-- <td>{{$student['student_attendance']['username']}}</td> --}}
                {{-- <td>{{$student['student_attendance']['student_code']}}</td> --}}

                <td>{{$student['subject_user_attendance']['subjects']['name']}}</td>
                <td>{{$student['count_all_lectures']}}</td>
                <td> {{count($student['subject_user_attendance']['lectures'])-$student['count_all_lectures']}}</td>
                <td> {{count($student['subject_user_attendance']['lectures'])}}</td>

            </tr>
        @endforeach
        @endif
        @if(count($studentWithNoAttendance) > 0)
        @foreach($studentWithNoAttendance as $studentWithNo)
            <tr>
                <td>{{$studentWithNo['subjectName']}}</td>
                <td>0 </td>
                <td> {{$studentWithNo['countOfAllLecturesOFSubject']}} </td>
                <td> {{$studentWithNo['countOfAllLecturesOFSubject']}}</td>


            </tr>
        @endforeach
        @endif
        </tbody>
    </table>
</div>

@endsection