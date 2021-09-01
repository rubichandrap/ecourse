<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $primaryKey = 'id';

    protected $foreignKey = 'user_id';

    protected $fillable = [
        'tempat_lahir', 'tanggal_lahir', 'pekerjaan', 'alamat', 'image',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}