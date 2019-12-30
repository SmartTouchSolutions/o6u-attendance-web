<form action="{{route('subject.update' , $subjectDetails->id)}}" method="post">
    {{ csrf_field() }}
    @method('PUT')
    Name:<input type="text" name="name" value="{{$subjectDetails->name}}"><br>
    @if ($errors->has('name'))
        <p class="alert alert-danger">{{ $errors->first('name') }}</p>
    @endif
    Subject:<input type="text" name="subject_code" value="{{$subjectDetails->subject_code}}">
    <br>
    @if ($errors->has('subject_code'))
        <p class="alert alert-danger">{{ $errors->first('subject_code') }}</p>
    @endif



    <input type="submit" name="Edit">
</form>
