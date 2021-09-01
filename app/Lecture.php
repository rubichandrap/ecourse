<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'modul_id',
        'title',
        'content',
        'urutan',
        'status',
    ];

    public function modul() {
        return $this->belongsTo(Modul::class);
    }
    
    public static function countLectures($id) {
        $lecture = Lecture::where('modul_id', $id)->count();
        return $lecture;
    }

    public function users() {
        return $this->belongsToMany(User::class, 'user_lectures');
    }
}
