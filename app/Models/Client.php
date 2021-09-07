<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\order;


class Client extends Model
{
    use HasFactory;
    public $guarded = [];
    protected $casts =  ['phone' => 'array'];

    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }
    public function orders()
    {
        return $this->hasMany(order::class  );
    }
}

    
