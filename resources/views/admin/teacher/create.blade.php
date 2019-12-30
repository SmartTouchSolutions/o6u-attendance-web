{{--@extends('layouts.adminapp')--}}
@section('title' , 'Add Teacher Assistant')

<form action="{{route('TeacherAssistant.store')}}" method="post">
    {{ csrf_field() }}

    <div class="create-cont-form">
        <label> - username :</label>
        <div class="mb-3">
            <input type="text" name="username" class="form-control" placeholder="username" aria-label="Username">
        </div>
        @if ($errors->has('username'))
            <p class="alert alert-danger">{{ $errors->first('username') }}</p>
        @endif

        <label> <i class="fas fa-file-alt"></i> email :</label>
        <div class="mb-3">
            <input type="email"  name="email" class="form-control" placeholder="email" aria-label="email">
        </div>
        @if ($errors->has('email'))
            <p class="alert alert-danger">{{ $errors->first('email') }}</p>
        @endif

        <label> <i class="fas fa-eye-slash"></i> Password :</label>
        <div class="mb-3">
            <input name="password" type="password" class="form-control" placeholder="Input Passowrd" aria-label="Username">
        </div>
        @if ($errors->has('password'))
            <p class="alert alert-danger">{{ $errors->first('password') }}</p>
        @endif


        subjects<br>
        @foreach($allSubjects as $subject)
            <input id="{{$subject->name}}" type="checkbox" name="subjects[]" value="{{$subject->id}}"><label for="{{$subject->name}}">{{$subject->name}}</label><br>
        @endforeach
        @if ($errors->has('subjects'))
            <p class="alert alert-danger">{{ $errors->first('subjects') }}</p>
        @endif

    </div>
    <div class="create-cont-footer">
        <div class="row">
            <div class="col-lg-1 order-last  col-8">
                <button  type="submit" class="btn btn-reset">Submit</button>
            </div>
