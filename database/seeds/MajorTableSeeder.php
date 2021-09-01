<?php

use Illuminate\Database\Seeder;
use App\Major;

class MajorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $major_si = new Major();
        $major_si->name = 'sistem informasi';
        $major_si->save();

        $major_it = new Major();
        $major_it->name = 'teknik informatika';
        $major_it->save();
    }
}
