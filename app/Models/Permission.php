<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public function role()
{
   return $this->belongsTo(Role::class);
}
}
