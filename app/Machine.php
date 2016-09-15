<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    //
    public function measurements()
    {
      return $this->hasMany('App\Measurement');
    }

    public function probes()
    {
      return $this->belongsToMany('App\Probe');
    }

    public function location()
    {
      return $this->belongsTo('App\Location');
    }

    public function codes()
    {
      return $this->hasMany('App\Code');
    }

    public function getCurrentcodeAttribute()
    {
      $code=$this->codes()->orderBy('created_at', 'DESC')->first();
      return $code;
    }

    public function getLastmeasurementAttribute()
    {
      $measure=$this->measurements()->orderBy('created_at', 'DESC')->first();
      if (!$measure)
      {
        return $this->created_at;
      };
      return $measure->created_at;
    }

    public function getNumberofmeasurementsAttribute()
    {
      return $this->measurements()->count();
    }

}
