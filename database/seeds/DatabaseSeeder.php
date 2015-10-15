<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\UsersModel;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(UserTableSeeder::class);

        Model::reguard();
    }
}

class UserTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('users')->delete();

        UsersModel::create([
            'name' => 'Foo Bar',
            'email' => 'foo@bar.com',
            'password' => bcrypt('abcdefgh')
        ]);
        UsersModel::create([
            'name' => 'Tester',
            'email' => 'tester@example.com',
            'password' => bcrypt('abcdefgh')
        ]);
    }

}