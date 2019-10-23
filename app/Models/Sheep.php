<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sheep extends Model
{
    protected $fillable = [
        'name', 'amount', 'corral_id'
    ];

    public function corral(){
        return $this->belongsTo(Corral::class);
    }
}
