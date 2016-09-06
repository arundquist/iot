<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function codes()
    {
      return $this->hasMany('App\Code');
    }

    public function getMachinesAttribute()
    {
      $codes=$this->codes;
      $machines=collect([]);
      foreach ($codes as $code)
      {
        $thismachine=$code->machine;
        $currentcode=$thismachine->currentcode;
        if (($code->id)==($currentcode->id))
        {
          $machines->push($thismachine);
        };
      };
      return $machines;
    }
}
