<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $primaryKey = 'id';

    protected $foreignKey = 'kelas_id';

    protected $fillable = [
        'kelas_id',
        'session_of',
        'title',
        'desc',
        'status',
    ];

    public function kelas() {
        return $this->belongsTo(Kelas::class);
    }

    public function posts() {
        return $this->hasMany(Post::class);
    }
}
