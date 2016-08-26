@extends('layouts.app')

@section('content')
<form action={{url("admin/users")}} method="POST">
    {{ csrf_field() }}

  
These are the approved users. Check them if you want to un-approve.
    <ul>
    @foreach ($approvedusers AS $user)
      <li><input type="checkbox"
         name="unapproveuser[{{{$user->id}}}]">{{{$user->name}}}</li>
    @endforeach
    </ul>
These are the unapproved users. Check them if you want to approve.
    <ul>
    @foreach ($unapprovedusers AS $user)
      <li><input type="checkbox"
         name="approveuser[{{{$user->id}}}]">{{{$user->name}}}</li>
    @endforeach
    </ul>

    <div>
        <input type="submit" value="approve users">
    </div>
</form>
@endsection
