<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TugasComment extends Model
{
    protected $table = 'tugas_comments';

protected $primaryKey = 'id';

protected $foreignKey = [
    'user_id',
    'tugas_id',
];

protected $fillable = [
    'user_id',
    'tugas_id',
    'content',
];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function tugas() {
        return $this->belongsTo(Tugas::class);
    }
}
