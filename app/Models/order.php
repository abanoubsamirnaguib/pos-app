<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\product;
use App\Models\Client;

class order extends Model
{
    use HasFactory;
    public $guarded = [];

    protected $casts = [
        'year' => 'timestamp',
    ];
    public function client()
    {
        return $this->belongsTo(Client::class );
    }
    public function products()
    {
        return $this->belongsToMany(product::class)->withPivot('quantity');;
    }
  

} 