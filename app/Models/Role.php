<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Klaravel\Ntrust\Traits\NtrustRoleTrait;

class Role extends Model
{
    use NtrustRoleTrait;

    /*
     * Role profile to get value from ntrust config file.
     */
    protected static $roleProfile = 'user';

    public function users()
      {
          return $this->hasMany('App\Models\User', 'role_user', 'user_id', 'role_id');
      }
}
