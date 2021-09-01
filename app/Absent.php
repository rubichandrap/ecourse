<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Absent extends Model
{
    protected $primaryKey = 'id';

    protected $foreignKey = [
        'user_id',
        'kelas_id',
        'session_id',
    ];

    protected $fillable = [
        'user_id',
        'kelas_id',
        'session_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function session()
    {
        return $this->belongsTo(Session::class);
    }
}
