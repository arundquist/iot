@extends('layouts.app')

@section('content')
<div class='container'>
  <ul>
    <li><a href="{{route('show users')}}">Authorize users</a></li>
    <li><a href="{{route('see all probes')}}">Probes</a></li>
    <li><a href="{{route('see all machines')}}">Machines</a></li>
  </ul>
</div>

@endsection
