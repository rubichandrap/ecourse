<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use App\Major;
use App\Profile;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_admin = Role::where('name', 'admin')->first();
        $role_dosen = Role::where('name', 'dosen')->first();
        $role_mahasiswa = Role::where('name', 'mahasiswa')->first();

        $major_si = Major::where('name', 'sistem informasi')->first();

        $admin = new User();
        $admin->nbm_nim = '000001';
        $admin->username = 'admin';
        $admin->name = 'Admin John';
       /*  $admin->prodi = ''; */
        $admin->email = 'admin@example.com';
        $admin->status = '1';
        $admin->register = '1';
        $admin->password = bcrypt('admin');
        $admin->save();
        $admin->profile()->save(new Profile);
        $admin->roles()->attach($role_admin);

        $dosen = new User();
        $dosen->nbm_nim = '512345';
        $dosen->username = 'dosen';
        $dosen->name = 'Dosen Mike';
        /* $dosen->prodi = ''; */
        $dosen->email = 'dosen@example.com';
        $dosen->status = '1';
        $dosen->register = '1';
        $dosen->password = bcrypt('dosen');
        $dosen->save();
        $dosen->profile()->save(new Profile);
        $dosen->roles()->attach($role_dosen);

        $mahasiswa = new User();
        $mahasiswa->nbm_nim = '17100004';
        $mahasiswa->username = 'mahasiswa';
        $mahasiswa->name = 'Mahasiswa Braun';
        $mahasiswa->email = 'mahasiswa@example.com';
        $mahasiswa->status = '1';
        $mahasiswa->register = '1';
        $mahasiswa->password = bcrypt('mahasiswa');
        $mahasiswa->save();
        $mahasiswa->profile()->save(new Profile);
        $mahasiswa->roles()->attach($role_mahasiswa);
        $mahasiswa->majors()->attach($major_si);
    }
}
