<?php

use Illuminate\Database\Seeder;
use App\User;

class SeoAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->email = 'admin@shared-lessons.org';
        $user->password = bcrypt('Admin@123');
        $user->role = 2;
        $user->name = 'admin';
        $user->is_verified = 1;
        $user->save();
    }
}
