<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    //
    public function machine()
    {
      return $this->belongsTo('App\Machine');
    }

    public function user()
    {
      return $this->belongsTo('App\User');
    }

}
