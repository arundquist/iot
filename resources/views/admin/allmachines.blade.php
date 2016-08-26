@extends('layouts.app')

@section('content')

<div class='container'>
  <table class='table table-bordered'>
    <tr><th>MAC address</th>
      <th>Location</th>
    </tr>
    @foreach ($machines AS $machine)
      <tr>
        <td><a href='{{route('machine edit',['id'=>$machine->id])}}' >{{{$machine->macaddress}}}</a></td>
        <td>{{{$machine->location->shortname}}}</td>
      </tr>
    @endforeach
  </table>
</div>


@endsection
