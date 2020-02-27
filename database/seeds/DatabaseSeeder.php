<?php

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
        // $this->call(UsersTableSeeder::class);
        DB::table('customer')->insert([
            'nickname'=>'張先生',
            'email'=>'admin@gmail.xxx',
            'account'=>'admin',
            'password'=>bcrypt('admin')
        ]);
    }
}
