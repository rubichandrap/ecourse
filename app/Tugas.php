<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    protected $table = 'tugas';

protected $primaryKey = 'id';

protected $foreignKey = [
    'user_id',
    'session_id',
];

protected $fillable = [
    'user_id',
    'session_id',
    'content',
    'file',
];

public function user() {
    return $this->belongsTo(User::class);
}

public function session() {
    return $this->belongsTo(Session::class);
}
}
