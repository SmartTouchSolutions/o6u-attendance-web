<form action="{{ route('doctor.store') }}" method="post">
	{{ csrf_field() }}
	username:<input type="text" name="username">
	email:<input type="email" name="email">
	password:<input type="password" name="password">
	re-password:<input type="password" name="password">
</form>