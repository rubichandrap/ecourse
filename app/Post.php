<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';

    protected $primaryKey = 'id';

    protected $foreignKey = [
        'user_id',
        'session_id',
    ];

    protected $fillable = [
        'user_id',
        'session_id',
        'content',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function session() {
        return $this->belongsTo(Session::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }
}
