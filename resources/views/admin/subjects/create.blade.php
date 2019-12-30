{{--@extends('layouts.adminapp')--}}
@section('title' , 'Add Subject')

<form action="{{route('subject.store')}}" method="post">
    {{ csrf_field() }}

    <div class="create-cont-form">
        <label> - Name :</label>
        <div class="mb-3">
            <input type="text" name="name" class="form-control" placeholder="Name" aria-label="Username">
        </div>
        @if ($errors->has('name'))
            <p class="alert alert-danger">{{ $errors->first('name') }}</p>
        @endif


        <label> <i class="fas fa-eye-slash"></i> subject_code :</label>
        <div class="mb-3">
            <input name="subject_code" type="text" class="form-control" placeholder="Input subject_code" aria-label="Username">
        </div>
        @if ($errors->has('subject_code'))
            <p class="alert alert-danger">{{ $errors->first('subject_code') }}</p>
        @endif



    </div>
    <div class="create-cont-footer">
        <div class="row">
            <div class="col-lg-1 order-last  col-8">
                <button  type="submit" class="btn btn-reset">Submit</button>
            </div>
