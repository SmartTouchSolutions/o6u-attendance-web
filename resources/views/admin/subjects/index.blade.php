
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
                                <i class="fas fa-align-left"></i> Subject
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
                <a href="{{route('subject.create')}}" class="btn adding"> Add subject </a>
            </div>
        </div>
        @if(session()->has('success'))
            <p align="center" class="alert alert-success">{{session()->get('success')}}</p>
        @endif
        <table class="tb table table-stuff table-responsive">
            <thead>
            <tr>
                <th style="width:140px;">Name</th>
                <th>subject_code</th>
                <th style="width:140px;">Created At</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($allsubject as $subject)
                <tr>
                    <td>{{$subject->name}}</td>
                    <td>{{$subject->subject_code}}</td>

                    <td>{{$subject->created_at->toDateString()}}</td>
                    <td>
                        <a href="{{route('subject.edit' , $subject->id)}}"><i class="far fa-edit mx-2"></i></a>
                        <i style="cursor:pointer;" data-toggle="modal" data-target="#exampleModal{{$subject->id}}" class="far fa-trash-alt"></i

                    </td>
                </tr>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal{{$subject->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <form action="{{route('subject.destroy' , $subject->id)}}" method="post">
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
        @if(isset($allsubject))
            {!! $allsubject->appends(request()->query())->render("pagination::bootstrap-4") !!}
        @endif
    </div>
@endsection
