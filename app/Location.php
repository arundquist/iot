<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    //
    public function machines()
    {
      return $this->HasMany('App\Machine');
    }

    public function measurements()
    {
      return $this->hasMany('App\Measurement');
    }

  


}
