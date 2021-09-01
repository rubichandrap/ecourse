<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modul extends Model
{
    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'desc',
        'slug',
        'image',
        'level',
        'platform',
        'status',
    ];

    public function lectures() {
        return $this->hasMany(Lecture::class);
    }

    public function deepSearch($search) {
        return $this->where('title', 'like', "%".$search."%")
        ->orWhere('level', 'like', "%".$search."%")
        ->orWhere('platform', 'like', "%".$search."%")
        ->orWhere('slug', 'like', "%".$search."%");
    }
}
