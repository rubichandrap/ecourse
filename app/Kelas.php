<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';

    protected $primaryKey = 'id';

    protected $foreignKey = [
        'user_id',
        'major_id',
    ];

    protected $fillable = [
        'user_id',
        'major_id',
        'total',
        'token',
        'status',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function user_joined() {
        return $this->belongsToMany(User::class, 'user_kelas');
    }

    public function sessions() {
        return $this->hasMany(Session::class);
    }
}
