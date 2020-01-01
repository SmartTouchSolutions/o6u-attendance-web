@extends('layouts.adminapp')
@section('content')
    @php $noSidebar=''; @endphp

    <div class="title3">
        <div class="row" style="margin:0;">
            <div class="col-md-10 my-2">
                <button type="button" id="sidebarCollapse" class="btn stf">
                    <i class="fas fa-user-tie"></i> Add subject
                </button>
            </div>
            <div class="col-md- my-2">
                <a href="{{ url('subject')}}" class="btn btn-dark"><i class="fas fa-arrow-left"></i>Back</a>
            </div>
        </div>
    </div>

    <div class="container">
        <form action="{{ route('subject.store') }}" method="post">
            {{ csrf_field() }}

            <div class="row">

                <div class="col-md-12">

                    <label class="mt-4 mr-2" for="inlineFormCustomSelectPref">Name</label><br>
                    <input class="form-control" type="text" placeholder="Enter name.." name="name">

                </div>
                @if ($errors->has('name'))
                    <p class="alert alert-danger">{{ $errors->first('name') }}</p>
                @endif
                <div class="col-md-12">

                    <label class="mt-4 mr-2" for="inlineFormCustomSelectPref">subject_code</label><br>
                    <input name="subject_code" class="form-control" type="text" placeholder="Enter subject_code..">

                </div>
                @if ($errors->has('subject_code'))
                    <p class="alert alert-danger">{{ $errors->first('subject_code') }}</p>
                @endif
            </div>
            <div class="row">
                <div class="col-md-12">


                <div class="col-md-12">

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
{{--@section('title' , 'Add Subject')--}}

{{--<form action="{{route('subject.store')}}" method="post">--}}
{{--    {{ csrf_field() }}--}}

{{--    <div class="create-cont-form">--}}
{{--        <label> - Name :</label>--}}
{{--        <div class="mb-3">--}}
{{--            <input type="text" name="name" class="form-control" placeholder="Name" aria-label="Username">--}}
{{--        </div>--}}
{{--        @if ($errors->has('name'))--}}
{{--            <p class="alert alert-danger">{{ $errors->first('name') }}</p>--}}
{{--        @endif--}}


{{--        <label> <i class="fas fa-eye-slash"></i> subject_code :</label>--}}
{{--        <div class="mb-3">--}}
{{--            <input name="subject_code" type="text" class="form-control" placeholder="Input subject_code" aria-label="Username">--}}
{{--        </div>--}}
{{--        @if ($errors->has('subject_code'))--}}
{{--            <p class="alert alert-danger">{{ $errors->first('subject_code') }}</p>--}}
{{--        @endif--}}



{{--    </div>--}}
{{--    <div class="create-cont-footer">--}}
{{--        <div class="row">--}}
{{--            <div class="col-lg-1 order-last  col-8">--}}
{{--                <button  type="submit" class="btn btn-reset">Submit</button>--}}
{{--            </div>--}}
