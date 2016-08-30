@extends('layouts.app')

@section('content')
<div class='container'>
<h1>Location: {{{$location->shortname}}}</h1>
<h2>Type: {{{$type}}}</h2>
<div class='row'>


<div>
{!! Plotly::dateplot($measurements)!!}
</div>
<div>
  {{{$measurements->count()}}} data points from {{{$measurements->first()->created_at->diffForHumans()}}}
  ({{{$measurements->first()->created_at}}})
  to {{{$measurements->last()->created_at->diffForHumans()}}}
  ({{{$measurements->last()->created_at}}}).
</div>
</div>
@endsection
