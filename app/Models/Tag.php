<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    // Añadir name a la propiedad fillable
    protected $fillable = ['name'];
    
    // app/Models/Tag.php
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

}
