<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(CategoryTableSeeder::class);
        $this->call(CommentTableSeeder::class);
        $this->call(PostTableSeeder::class);

        $user=new User();
        $user->name='bob smith';
        $user->email='bob@gmail.com';
        $user->password=bcrypt('password');
        $user->save();

        $user=new User();
        $user->name='anna jack';
        $user->email='anna@gmail.com';
        $user->password=bcrypt('password');
        $user->save();
    }
}
