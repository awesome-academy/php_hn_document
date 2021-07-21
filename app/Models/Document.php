<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Category;

class Document extends Model
{
    protected $fillable = [
        'name',
        'description',
        'url',
        'category_id',
        'user_id',
    ];

    public function downloads()
    {
        return $this->belongsToMany(User::class, 'downloads')->withTimestamps();
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    public function comments()
    {
        return $this->belongsToMany(User::class, 'comments')->withPivot('content')->withTimestamps();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
