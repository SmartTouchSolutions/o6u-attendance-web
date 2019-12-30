@extends('layouts.adminapp')
@section('title' , 'Login Page')
@php $noSidebar=''; @endphp
@section('content')
<div class="page-content">

    <div class="logo-form-container2">
        <div class="logo-form2">
            <form action="{{route('loginPost')}}" method="post">
               {{ csrf_field()  }}
               <div class="row" style="margin:0;">
                <div class="col-md-12 inp2" style="text-align: center;">
                    <img src="{{asset('img/logo2.png')}}" style="width:40%;">
                </div>
                <div class="col-md-12 my-3 inp2">
                    <label><i class="far fa-user mx-1"></i> Username : </label><br>
                    <input class="form-control" type="text"placeholder=" Enter Your Username .." name="username" value="@if(old('username')) {{old('username')}} @endif">

                </div>

                <div class="col-md-12 pb-5 inp2">
                    <label><i class="far fa-eye-slash mx-1"></i> Password :</label><br>
                    <input class="form-control" type="password"  placeholder=" Enter Your Password.." name="password">

                </div>
                <div class="col-md-12 pb-5 inp2">
                   <input type="submit" value="Login">
               </div>


           </div>
       </form>
       @if(Session::has('error'))
       <p class="alert alert-danger">{{ Session::get('error') }}</p>
       @endif
       @if ($errors->has('username'))
       <p class="alert alert-danger">{{ $errors->first('username') }}</p>
       @endif

       @if ($errors->has('password'))
       <p class="alert alert-danger">{{ $errors->first('password') }}</p>
       @endif
   </div>
</div>
</div>
@endsection

