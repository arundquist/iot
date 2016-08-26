@extends('layouts.app')

@section('content')

<div class='container'>
  <table class='table table-bordered'>
    <tr><th>Probe name</th>
        <th>Description</th>
        <th>Type</th>
        <th>Units</th>
    </tr>
    @foreach ($probes AS $probe)
      <tr>
        <td><a href='{{route('add or edit probe',['id'=>$probe->id])}}' >{{{$probe->name}}}</a></td>
        <td>{{{$probe->description}}}</td>
        <td>{{{$probe->type}}}</td>
        <td>{{{$probe->units}}}</td>
      </tr>
    @endforeach
  </table>
</div>


@endsection
