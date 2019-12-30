<form action="{{route('TeacherAssistant.update' , $teacherDetails->id)}}" method="post">
    {{ csrf_field() }}
    @method('PUT')
    username:<input type="text" name="username" value="{{$teacherDetails->username}}"><br>
    @if ($errors->has('username'))
        <p class="alert alert-danger">{{ $errors->first('username') }}</p>
    @endif
    email:<input type="email" name="email" value="{{$teacherDetails->email}}">
    <br>
    @if ($errors->has('email'))
        <p class="alert alert-danger">{{ $errors->first('email') }}</p>
    @endif
    New password<input type="text" name="password">
    <br>
    @if ($errors->has('password'))
        <p class="alert alert-danger">{{ $errors->first('password') }}</p>
    @endif


    subjects<br>
    @foreach($allSubjects as $subject)
        <input @if(in_array($subject->id, $teacherSubjects)) {{'checked'}} @endif id="{{$subject->name}}" type="checkbox" name="subjects[]" value="{{$subject->id}}"><label for="{{$subject->name}}">{{$subject->name}}</label><br>
    @endforeach
    @if ($errors->has('subjects'))
        <p class="alert alert-danger">{{ $errors->first('subjects') }}</p>
    @endif
    <input type="submit" name="Edit">
</form>
