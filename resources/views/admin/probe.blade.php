@extends('layouts.app')

@section('content')
<div class='container'>

  <form action='{{url("admin/probe/$probe->id")}}' method='POST'>

      {{ csrf_field() }}

  <input type='text' name='name' placeholder='name' value='{{{$probe->name}}}'><br/>
  <input type='text' name='type' placeholder='type' value='{{{$probe->type}}}'><br/>
  <input type='text' name='units' placeholder='units' value='{{{$probe->units}}}'><br/>
  <textarea name='description' cols='40' rows='10' placeholder="description">{{{$probe->description}}}
  </textarea><br/>

  <input type='submit' name='submit probe'>
  </form>
</div>

@endsection
