@extends('layouts.app')

@section('content')
<div class='container'>
<h1>Location: {{{$location->shortname}}}</h1>
<h2>Type: {{{$type}}}</h2>
<div class='row'>


<div>
{!! Plotly::dateplot($measurements, $type, $units)!!}
</div>
<div>
  {{{$measurements->count()}}} data points from {{{$measurements->first()->created_at->diffForHumans()}}}
  ({{{$measurements->first()->created_at}}})
  to {{{$measurements->last()->created_at->diffForHumans()}}}
  ({{{$measurements->last()->created_at}}}).
</div>
<div>
  Download data:
  <ul>
    <li><a href='{{{route('measurements',['location_id'=>$location->id,
                                      'type'=>$type,
                                      'format'=>'raw'])}}}'>JSON</a>
    </li>
    <li><a href='{{{route('measurements',['location_id'=>$location->id,
                                      'type'=>$type,
                                      'format'=>'excel'])}}}'>Excel 2007</a>
    </li>
    <li><a href='{{{route('measurements',['location_id'=>$location->id,
                                      'type'=>$type,
                                      'format'=>'csv'])}}}'>CSV</a>
    </li>
    <li><a href='{{{route('measurements',['location_id'=>$location->id,
                                      'type'=>$type,
                                      'format'=>'html'])}}}'>HTML table</a>
    </li>
  </ul>
</div>
</div>
@endsection
