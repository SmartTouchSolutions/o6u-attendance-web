@extends('layouts.adminapp')
@section('content')
    @php $noSidebar=''; @endphp
    <div class="title3">
        <div class="row" style="margin:0;">
            <div class="col-md-5 my-2">
                <button type="button" id="sidebarCollapse" class="btn stf">
                    <i class="fas fa-user-tie"></i> Edit subject
                </button>
            </div>
        </div>
    </div>

    <div class="container">
        <form action="{{route('subject.update' , $subjectDetails->id)}}" method="post" class="form prof-sel">
            {{ csrf_field() }}
            @method('PUT')

            <div class="row">

                <div class="col-md-12">

                    <label class="mt-4 mr-2" for="inlineFormCustomSelectPref">Name</label><br>
                    <input class="form-control" type="text" placeholder="Enter user name.." name="name" value="{{$subjectDetails->name}}">

                </div>
                @if ($errors->has('name'))
                    <p class="alert alert-danger">{{ $errors->first('name') }}</p>
                @endif
                <div class="col-md-12">

                    <label class="mt-4 mr-2" for="inlineFormCustomSelectPref">subject_code</label><br>
                    <input name="subject_code" class="form-control" type="text" placeholder="Enter subject_code.."value="{{$subjectDetails->subject_code}}">

                </div>
                @if ($errors->has('subject_code'))
                    <p class="alert alert-danger">{{ $errors->first('subject_code') }}</p>
                @endif
            </div>


            <!-- <div class="col-md-6">

                        <label class="mt-4 mr-2" for="inlineFormCustomSelectPref">Date Created</label><br>
                        <input class="form-control" type="text" placeholder="Enter Date..">

                </div> -->
            <div class="row my-4" style="text-align:right;">
                <div class="col-md-3">
                    <button class="btn adding">Submit</button>
                </div>
            </div>

        </form>
    </div>


@endsection
