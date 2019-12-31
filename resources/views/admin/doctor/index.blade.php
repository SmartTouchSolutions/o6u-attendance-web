@extends('layouts.adminapp')
@section('title' , 'All Doctors')
@section('content')
<!-- Page Content  -->

<div id="content">
    <nav>
        <div>
            <div class="title2">
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
        <table class="tb table table-stuff">
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
                <td style="padding:10px;">
                    <a href="{{route('doctor.edit' , $doctor->id)}}"><i class="far fa-edit mx-2"></i></a>

                    <i style="cursor:pointer;" data-toggle="modal" data-target="#exampleModal{{$doctor->id}}" class="far fa-trash-alt"></i>
                    
                </td>
            </tr>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal{{$doctor->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel" style="text-align:center;"> Alert ! </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure that you want to delete this ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <form action="{{route('doctor.destroy' , $doctor->id)}}" method="post">
                                    {{ csrf_field() }}
                                    @method('DELETE')
                                    
                        <button type="submit" class="btn btn-primary">Delete </button>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
            
            @endforeach
            </tbody>
        </table>
    @if(isset($allDoctors))
        {!! $allDoctors->appends(request()->query())->render("pagination::bootstrap-4") !!}
    @endif
</div>

@endsection
