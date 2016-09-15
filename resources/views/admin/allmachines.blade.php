@extends('layouts.app')

@section('content')

<div class='container'>
  <table class='table table-bordered'>
    <tr><th>MAC address</th>
      <th>Location</th>
      <th>added to database</th>
      <th>Last Measurement</th>
      <th>Total measurments</th>
    </tr>
    @foreach ($machines AS $machine)
      <tr>
        <td><a href='{{route('machine edit',['id'=>$machine->id])}}' >{{{$machine->macaddress}}}</a></td>
        <td>{{{$machine->location->shortname}}}</td>
        <td>{{{$machine->created_at}}} ({{{$machine->created_at->diffForHumans()}}})</td>
        <td>{{{$machine->lastmeasurement}}} ({{{$machine->lastmeasurement->diffForHumans()}}})</td>
        <td>{{{$machine->numberofmeasurements}}}</td>
      </tr>
    @endforeach
  </table>
</div>


@endsection
