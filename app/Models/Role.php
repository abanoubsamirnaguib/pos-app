<?php

namespace App\Models;

use Laratrust\Models\LaratrustRole;
use App\Models\User;


class Role extends LaratrustRole
{
    public $guarded = [];

    // public function orders()
    // {
    //     return $this->BelongsToMany(User::class );
    // }
}
