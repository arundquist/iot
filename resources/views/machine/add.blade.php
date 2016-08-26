@extends('layouts.app')

@section('content')

@if (isset($machine))
  <form action='{{url("machine/edit/$machine->id")}}' method='POST'>
@else
  <form action='{{url("machine/add")}}' method="POST">
@endif
    {{ csrf_field() }}

    <div>
      <input type='text' name='macaddress' placeholder='MAC address'
        @if (isset($machine))
          value="{{$machine->macaddress}}"
        @endif
        >
    </div>

    <div>
      <p>Select the probes that are connected (note: if you have a new probe please contact an admin to add it to the list)</p>
      <ul>
      @if (isset($machine))

        @foreach ($machine->probes AS $probe)
          <li><input type='checkbox' name='probes[{{{$probe->id}}}]' value='1' checked>{{{$probe->shortname}}}: {{{$probe->description}}}</li>
        @endforeach
      @endif

      @foreach ($probes AS $probe)
        <li><input type='checkbox' name='probes[{{{$probe->id}}}]' >{{{$probe->shortname}}}: {{{$probe->description}}}</li>
      @endforeach
      </ul>
    </div>

      If the machine is at a location that's not in the list below, please enter it's new location information<br/>

    <div>
      <input type='text' name='locationshort' placeholder='Location short name'><br/>
      <textarea name='locationdescription' cols='40' rows='10' placeholder="location description">
        location description
      </textarea><br/>
      <input type='text' name='locationgps' placeholder='Location GPS'>
    </div>

    <div>
      <ul>
        @if(isset($machine))
          <li><input type='radio' name='locationid' value='{{{$machine->location->id}}}' checked > {{{$machine->location->shortname}}}
            : {{{$machine->location->description}}}</li>
        @endif
          <li><input type='radio' name='locationid' value='-1'
              @if (!isset($machine))
                checked
              @endif
               >enter new location above</li>


        @foreach ($locations AS $location)
        <li><input type='radio' name='locationid' value='{{{$location->id}}}' > {{{$location->shortname}}}
          : {{{$location->description}}}</li>
        @endforeach
      </ul>
    </div>


    <div>
      New code can be put here.<br/>
      <textarea name='code' cols='40' rows='10' placeholder="arduino code">arduino code</textarea><br/>
      @if (isset($machine))
        Existing code:<br/>
        <code>{{{$machine->currentcode->code}}}</code>
      @endif
    </div>
    <div>
      @if (isset($machine))
        <input type='submit' name='edit machine'>
      @else
        <input type='submit' name='add machine'>
      @endif
    </div>

</form>
hi there
@endsection
