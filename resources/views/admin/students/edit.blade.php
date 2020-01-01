@extends('layouts.adminapp')
@section('content')
    @php $noSidebar=''; @endphp

    <div class="title3">
        <div class="row" style="margin:0;">
            <div class="col-md-10 my-2">
                <button type="button" id="sidebarCollapse" class="btn stf">
                    <i class="fas fa-user-tie"></i> Edit Student
                </button>
            </div>
            <div class="col-md- my-2">
                <a href="{{ url('student')}}" class="btn btn-dark"><i class="fas fa-arrow-left"></i>Back</a>
            </div>
        </div>
    </div>

    <div class="container">
        <form action="{{ route('student.update',$studentDetails->id) }}" method="post">
            {{ csrf_field() }}
            @method('PUT')

            <div class="row">

                <div class="col-md-12">

                    <label class="mt-4 mr-2" for="inlineFormCustomSelectPref">User name</label><br>
                    <input class="form-control" type="text" placeholder="Enter user name.." name="username" value="{{$studentDetails->username}}">

                </div>
                @if ($errors->has('username'))
                    <p class="alert alert-danger">{{ $errors->first('username') }}</p>
                @endif
            </div>
            <div class="row">
                <div class="col-md-12">



                    <label class="mt-4 mr-2" for="inlineFormCustomSelectPref">student_code</label><br>
                    <input class="form-control" type="text" placeholder="Enter student_code.." name="student_code" value="{{$studentDetails->student_code}}">

                </div>
                @if ($errors->has('student_code'))
                    <p class="alert alert-danger">{{ $errors->first('student_code') }}</p>
                @endif
                <div class="col-md-12">
                    <label class="mt-4 mr-2" for="inlineFormCustomSelectPref">Subjects :</label><br>

                    @foreach($allSubjects as $subject)
                        <input @if(in_array($subject->id, $allSubjectsOfStudent)) {{'checked'}} @endif id="{{$subject->name}}" type="checkbox" name="subjects[]" value="{{$subject->id}}"><label class="sub" for="{{$subject->name}}">{{$subject->name}}</label><br>                    @endforeach
                </div>
                @if ($errors->has('subjects'))
                    <p class="alert alert-danger">{{ $errors->first('subjects') }}</p>
                @endif
            </div>
            <div class="row">
                <div class="col-md-12">

                    <label class="mt-4 mr-2" for="inlineFormCustomSelectPref">Password</label><br>
                    <input class="form-control" type="password" placeholder="Enter your password .." name="password">
                </div>
                @if ($errors->has('password'))
                    <p class="alert alert-danger">{{ $errors->first('password') }}</p>
            @endif
            <!-- <div class="col-md-6">

                        <label class="mt-4 mr-2" for="inlineFormCustomSelectPref">Date Created</label><br>
                        <input class="form-control" type="text" placeholder="Enter Date..">

                </div> -->
            </div>
            <div class="row my-4" style="text-align:right;">
                <div class="col-md-3">
                    <button class="btn adding">Submit</button>
                </div>
            </div>
        </form>
    </div>
@endsection








{{--@extends('layouts.adminapp')--}}
{{--@section('title' , 'Add  Student')--}}

{{--<form action="{{route('student.store')}}" method="post">--}}
{{--    {{ csrf_field() }}--}}

{{--    <div class="create-cont-form">--}}
{{--        <label> - username :</label>--}}
{{--        <div class="mb-3">--}}
{{--            <input type="text" name="username" class="form-control" placeholder="username" aria-label="Username">--}}
{{--        </div>--}}
{{--        @if ($errors->has('username'))--}}
{{--            <p class="alert alert-danger">{{ $errors->first('username') }}</p>--}}
{{--        @endif--}}


{{--        <label> <i class="fas fa-eye-slash"></i> Password :</label>--}}
{{--        <div class="mb-3">--}}
{{--            <input name="password" type="password" class="form-control" placeholder="Input Passowrd" aria-label="Username">--}}
{{--        </div>--}}
{{--        @if ($errors->has('password'))--}}
{{--            <p class="alert alert-danger">{{ $errors->first('password') }}</p>--}}
{{--        @endif--}}

{{--        <label> <i class="fas fa-eye-slash"></i> student_code :</label>--}}
{{--        <div class="mb-3">--}}
{{--            <input name="student_code" type="text" class="form-control" placeholder="student_code" aria-label="student_code">--}}
{{--        </div>--}}
{{--        @if ($errors->has('student_code'))--}}
{{--            <p class="alert alert-danger">{{ $errors->first('student_code') }}</p>--}}
{{--        @endif--}}
{{--        subjects<br>--}}
{{--        @foreach($allSubjects as $subject)--}}
{{--            <input id="{{$subject->name}}" type="checkbox" name="subjects[]" value="{{$subject->id}}"><label for="{{$subject->name}}">{{$subject->name}}</label><br>--}}
{{--        @endforeach--}}
{{--        @if ($errors->has('subjects'))--}}
{{--            <p class="alert alert-danger">{{ $errors->first('subjects') }}</p>--}}
{{--        @endif--}}


{{--    </div>--}}
{{--    <div class="create-cont-footer">--}}
{{--        <div class="row">--}}
{{--            <div class="col-lg-1 order-last  col-8">--}}
{{--                <button  type="submit" class="btn btn-reset">Submit</button>--}}
{{--            </div>--}}





{{--@extends('layouts.adminapp')--}}
{{--@section('content')--}}
{{--    @php $noSidebar=''; @endphp--}}
{{--    <div class="title3">--}}
{{--        <div class="row" style="margin:0;">--}}
{{--            <div class="col-md-5 my-2">--}}
{{--                <button type="button" id="sidebarCollapse" class="btn stf">--}}
{{--                    <i class="fas fa-user-tie"></i> Edit teacher--}}
{{--                </button>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}


{{--    <div class="container">--}}
{{--        <form action="{{route('student.update' , $studentDetails->id)}}" method="post" class="form prof-sel">--}}
{{--            {{ csrf_field() }}--}}
{{--            @method('PUT')--}}

{{--            <div class="row">--}}

{{--                <div class="col-md-12">--}}

{{--                    <label class="mt-4 mr-2" for="inlineFormCustomSelectPref">User name</label><br>--}}
{{--                    <input class="form-control" type="text" placeholder="Enter user name.." name="username" value="{{$studentDetails->username}}">--}}

{{--                </div>--}}
{{--                @if ($errors->has('username'))--}}
{{--                    <p class="alert alert-danger">{{ $errors->first('username') }}</p>--}}
{{--                @endif--}}

{{--            </div>--}}

{{--            <div class="col-md-12">--}}
{{--                    <label class="mt-4 mr-2" for="inlineFormCustomSelectPref">Subjects :</label><br>--}}

{{--                    @foreach($allSubjects as $subject)--}}
{{--                        <input @if(in_array($subject->id, $studentSubjects)) {{'checked'}} @endif id="{{$subject->name}}" type="checkbox" name="subjects[]" value="{{$subject->id}}"><label class="sub" for="{{$subject->name}}">{{$subject->name}}</label><br>--}}
{{--                    @endforeach--}}
{{--                </div>--}}
{{--                @if ($errors->has('subjects'))--}}
{{--                    <p class="alert alert-danger">{{ $errors->first('subjects') }}</p>--}}
{{--                @endif--}}
{{--            </div>--}}
{{--            <div class="row">--}}
{{--                <div class="col-md-12">--}}

{{--                    <label class="mt-4 mr-2" for="inlineFormCustomSelectPref">Password</label><br>--}}
{{--                    <input class="form-control" type="password" placeholder="Enter your password .." name="password">--}}
{{--                </div>--}}
{{--                @if ($errors->has('password'))--}}
{{--                    <p class="alert alert-danger">{{ $errors->first('password') }}</p>--}}
{{--            @endif--}}
{{--            <!-- <div class="col-md-6">--}}

{{--                        <label class="mt-4 mr-2" for="inlineFormCustomSelectPref">Date Created</label><br>--}}
{{--                        <input class="form-control" type="text" placeholder="Enter Date..">--}}

{{--                </div> -->--}}
{{--            </div>--}}
{{--            <div class="row my-4" style="text-align:right;">--}}
{{--                <div class="col-md-3">--}}
{{--                    <button class="btn adding">Submit</button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </form>--}}
{{--    </div>--}}

{{--@endsection--}}
