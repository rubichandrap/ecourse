<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nbm_nim', 'username', 'name', 'prodi', 'semester', 'email', 'password', 'status', 'register',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles() {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function assignRoles(Role $role) {
        return $this->roles()->save($role);
    }

    public function hasRole($roleName)
    {
        foreach ($this->roles()->get() as $role)
        {
            if ($role->name == $roleName)
            {
                return true;
            }
        }
        return false;
    }

    public function majors() {
        return $this->belongsToMany(Major::class, 'user_majors');
    }

    public function assignMajors(Major $major) {
        return $this->majors()->save($major);
    }

    public function profile() {
        return $this->hasOne(Profile::class);
    }

    public function kelas() {
        return $this->hasMany(Kelas::class);
    }

    public function kelas_joined() {
        return $this->belongsToMany(Kelas::class, 'user_kelas');
    }

    public function absents() {
        return $this->hasMany(Absent::class);
    }

    public function lectures() {
        return $this->belongsToMany(Lecture::class, 'user_lectures');
    }

    public function hasLectures($lecture_id) {
        foreach ($this->lectures()->get() as $lecture) {
            if ($lecture->id == $lecture_id)
            {
                return true;
            }
            return false;
        }
    }
}
