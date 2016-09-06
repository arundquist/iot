@extends('layouts.app')

@section('content')
<div class='container'>
  <table class='table table-bordered'>
    <tr>
      <th>MAC address</th>
      <th>location</th>
      <th>probes</th>
    </tr>
    @foreach ($machines as $machine)
      <tr>
        <td><a href='{{route('machine edit',['id'=>$machine->id])}}' >{{{$machine->macaddress}}}</a></td>
        <td>{{{$machine->location->shortname}}}: {{{$machine->location->description}}}</td>
        <td>
          <ul>
            @foreach ($machine->probes AS $probe)
              <li>{{{$probe->type}}}</li>
            @endforeach
          </ul>
        </td>
      </tr>
    @endforeach
  </table>

</div>


@endsection
