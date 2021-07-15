<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Document;

class Category extends Model
{
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
}
