@extends('layouts.adminapp')
@section('content')
@php $noSidebar=''; @endphp
<!-- <form action="{{ route('doctor.store') }}" method="post"> -->
	<!-- {{ csrf_field() }}
	username:<input type="text" name="username">
	email:<input type="email" name="email">
	password:<input type="password" name="password">
	re-password:<input type="password" name="password">
</form> -->
<div class="title3">
	<div class="row" style="margin:0;">
		<div class="col-md-5 my-2">
			<button type="button" id="sidebarCollapse" class="btn stf">
				<i class="fas fa-user-tie"></i> Add Professor
			</button>   
		</div>
	</div> 
</div>

<div class="container">
<form action="{{ route('doctor.store') }}" method="post">
{{ csrf_field() }}

            <div class="row">
				
                <div class="col-md-12">
                    
						<label class="mt-4 mr-2" for="inlineFormCustomSelectPref">User name</label><br>
						<input class="form-control" type="text" placeholder="Enter user name.." name="username">
                    
				</div>
				@if ($errors->has('username'))
    			<p class="alert alert-danger">{{ $errors->first('username') }}</p>
				@endif
                <div class="col-md-12">
                    
                        <label class="mt-4 mr-2" for="inlineFormCustomSelectPref">Name</label><br>
                        <input name="name" class="form-control" type="text" placeholder="Enter Name..">
                    
				</div>
				@if ($errors->has('name'))
    			<p class="alert alert-danger">{{ $errors->first('name') }}</p>
				@endif
            </div>
            <div class="row">
                <div class="col-md-12">
                    
						<label class="mt-4 mr-2" for="inlineFormCustomSelectPref">Email</label><br>
						<input class="form-control" type="text" placeholder="Enter your email.." name="email">
                    
				</div>
				@if ($errors->has('email'))
    			<p class="alert alert-danger">{{ $errors->first('email') }}</p>
				@endif					
                <div class="col-md-12">
				<label class="mt-4 mr-2" for="inlineFormCustomSelectPref">Subjects :</label><br>

				@foreach($allSubjects as $subject) 
				<input id="{{$subject->name}}" type="checkbox" name="subjects[]" value="{{$subject->id}}"><label class="sub" for="{{$subject->name}}">{{$subject->name}}</label><br>
				@endforeach
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