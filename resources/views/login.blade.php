@extends('layouts.adminapp')
@section('title' , 'Login Page')
@php $noSidebar=''; @endphp
<form action="{{route('loginPost')}}" method="post">
{{ csrf_field()  }}
username<input type="text" name="username">
    @if ($errors->has('username'))
        <p class="alert alert-danger">{{ $errors->first('username') }}</p>
    @endif
password<input type="password" name="password">
    @if ($errors->has('password'))
        <p class="alert alert-danger">{{ $errors->first('password') }}</p>
    @endif

    <input type="submit" value="Login">
</form>

@if(Session::has('error'))
    <p class="alert alert-danger">{{ Session::get('error') }}</p>
@endif


