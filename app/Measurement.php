<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Measurement extends Model
{
    //
    public function machine()
    {
      return $this->belongsTo('App\Machine');
    }

    public function probe()
    {
      return $this->belongsTo('App\Probe');
    }

    public function location()
    {
      return $this->belongsTo('App\Location');
    }

}
