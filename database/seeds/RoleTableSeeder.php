<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_admin = new Role();
        $role_admin->name = 'admin';
        $role_admin->save();

        $role_dosen = new Role();
        $role_dosen->name = 'dosen';
        $role_dosen->save();

        $role_mahasiswa = new Role();
        $role_mahasiswa->name = 'mahasiswa';
        $role_mahasiswa->save();
    }
}
