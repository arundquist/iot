@extends('layouts.app')

@section('content')

<h1>{{{$location->shortname}}}</h1>
<div>
  <p>{{{$location->description}}}</p>
</div>
<div>
  <ul>
    @foreach ($types AS $probe_id => $type)
      <li><a href='{{{route('measurements',[$location->id, $type])}}}'>{{{$type}}}</a></li>
    @endforeach
  </ul>
</div>

@endsection
