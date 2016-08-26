@extends('layouts.app')

@section('content')
<div class='container'>
<h1>Location: {{{$location->shortname}}}</h1>
<h2>Type: {{{$type}}}</h2>
<div class='row'>
  <div class='col-md-3'>
  <table class='table table-bordered'>
    <tr><th>Date</th>
      <th>Value ({{{$units}}})</th></tr>

    @foreach ($measurements AS $measurement)
      <tr><td>{{{$measurement->created_at->toDateTimeString()}}}</td>
        <td>{{{$measurement->measurement}}}</td></tr>
    @endforeach
  </table>
  </div>
<div class='col-md-9'>
{!!Plotly::dateplot($measurements)!!}
</div>
</div>
@endsection
