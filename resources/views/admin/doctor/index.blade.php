@extends('layouts.adminapp')
@section('title' , 'All Doctors')
@section('content')
<!-- Page Content  -->
<div id="content">
    <nav>
        <div>
            <div class="title">
                <div class="row" style="margin:0;">
                    <div class="col-md-5 my-2">
                        <button type="button" id="sidebarCollapse" class="btn stf">
                            <i class="fas fa-align-left"></i> Professors
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

        <div class="col-md-4 my-2" style="text-align:right;">
            <a href="{{route('doctor.create')}}" class="btn adding"> Add Professor </a>
        </div>
    </div>
        @if(session()->has('success'))
            <p align="center" class="alert alert-success">{{session()->get('success')}}</p>
        @endif
        <table class="tb table table-stuff table-responsive">
            <thead>
            <tr>
                <th style="width:140px;">UserName</th>
                <th style="width:140px;">Name</th>
                <th>Email</th>
                <th>Subjects</th>
                <th style="width:140px;">Created At</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($allDoctors as $doctor)
            <tr>
                <td>{{$doctor->username}}</td>
                <td>{{$doctor->name}}</td>
                <td>{{$doctor->email}}</td>
                @php
                    $getsubjectIDS = \DB::table('subject_users')->where('users_id' , 'LIKE' , '%'.$doctor->id.'%')->pluck('subject_id')->toArray();
                    $subjectsname = App\Subject::whereIn('id'  , $getsubjectIDS )->pluck('name')->toArray();
                    $subjectsnameImplode = implode(',' , $subjectsname);
                @endphp
                <td>{{$subjectsnameImplode}}</td>
                <td>{{$doctor->created_at->toDateString()}}</td>
                <td>
                    <a href="{{route('doctor.edit' , $doctor->id)}}"><i class="far fa-edit mx-2"></i></a>
                    <form action="{{route('doctor.destroy' , $doctor->id)}}" method="post">
                        {{ csrf_field() }}
                        @method('DELETE')
                        <button type="submit"><i class="far fa-trash-alt"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    @if(isset($allDoctors))
        {!! $allDoctors->appends(request()->query())->render("pagination::bootstrap-4") !!}
    @endif
</div>
@endsection
