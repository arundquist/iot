@extends('layouts.app')

@section('content')
<table class='table table-bordered'>
  <tr>
    <th>Date</th>
    <th>Measurement</th>
  </tr>
  @foreach ($measurements AS $measurement)
    <tr>
      <td>{{{$measurement->created_at}}}</td>
      <td>{{{$measurement->measurement}}}</td>
    </tr>
  @endforeach
</table>  

@endsection
