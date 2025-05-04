<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // Asegúrate de que los campos sean asignables masivamente
    protected $fillable = ['content', 'user_id', 'post_id'];

    // Definir las relaciones con Post y User si es necesario
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
