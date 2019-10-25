<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Sheep extends Model
{
    use LogsActivity;
    protected $fillable = [
        'name', 'corral_id', 'date'
    ];
    protected static $logAttributes = ['name', 'corral_id', 'date'];

    public function corral(){
        return $this->belongsTo(Corral::class);
    }
}
