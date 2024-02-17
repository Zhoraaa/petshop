<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        "theme", "text", "post_type_id", "author_id", "reply_to"
    ];

    public function replies()
    {
        return $this->hasMany(Post::class, 'reply_to')
            ->join('users', 'posts.author_id', '=', 'users.id')
            ->select('posts.*', 'users.login as author');
    }
}
