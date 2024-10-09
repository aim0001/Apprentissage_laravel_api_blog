<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'post_id', 'user_id'];

    // Relation avec l'utilisateur (auteur du commentaire)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec le post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
