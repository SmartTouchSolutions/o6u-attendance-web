@extends('layouts.adminapp')
@section('title' , 'All Teacher Assistant')
@section('content')
    <!-- Page Content  -->
    <div id="content">
        <nav>
            <div>
                <div class="title2">
                    <div class="row" style="margin:0;">
                        <div class="col-md-5 my-2">
                            <button type="button" id="sidebarCollapse" class="btn stf">
                                <i class="fas fa-align-left"></i> Teacher Assistant
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
                <a href="{{route('TeacherAssistant.create')}}" class="btn adding"> Add Teacher Assistant </a>
            </div>
        </div>

        <table class="tb table table-stuff table-responsive">
            <thead>
            <tr>
                <th style="width:140px;">UserName</th>
                <th>Email</th>
                <th>Subjects</th>
                <th style="width:140px;">Created At</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($allTeacherAssistants as $TeacherAssistant)
                <tr>
                    <td>{{$TeacherAssistant->username}}</td>
                    <td>{{$TeacherAssistant->email}}</td>
                    @php
                        $getsubjectIDS = \DB::table('subject_users')->where('users_id' , 'LIKE' , '%'.$TeacherAssistant->id.'%')->pluck('subject_id')->toArray();
                        $subjectsname = App\Subject::whereIn('id'  , $getsubjectIDS )->pluck('name')->toArray();
                        $subjectsnameImplode = implode(',' , $subjectsname);
                    @endphp
                    <td>{{$subjectsnameImplode}}</td>
                    <td>{{$TeacherAssistant->created_at->toDateString()}}</td>
                    <td>
                        <a href="{{route('TeacherAssistant.edit',$TeacherAssistant->id)}}"><i class="far fa-edit mx-2" style="padding-right: 5px;cursor: pointer;"> </i></a>
                    <form action="{{route('TeacherAssistant.destroy',$TeacherAssistant->id)}}" method="post">
                        {{csrf_field()}}
                        @method('DELETE')
                        <button type="submit">
                            <i class="far fa-trash-alt" style="padding-right: 5px;cursor: pointer;"> </i>
                        </button>
                    </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @if(isset($allTeacherAssistants))
            {!! $allTeacherAssistants->appends(request()->query())->render("pagination::bootstrap-4") !!}
        @endif
    </div>
@endsection
