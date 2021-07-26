<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $fillable = [
        'value',
        'quantity',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
