@extends('layouts.app')

@section('content')

<ul>
  @foreach ($locations AS $location)
    <li><a href='{{{route('single location', $location->id)}}}'>{{{$location->shortname}}}</a>: {{{$location->description}}}</li>
  @endforeach
</ul>

@endsection
