<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        factory(App\User::class, 10)->create();

        //create super admin (kind of)
        App\User::create(
                ['firstname'      => "Atypical",
                 'lastname'       => "SuperUser",
                 'email'          => 'vyatsyuk@atypicalbrands.com',
                 'password'       => bcrypt('abcABC123'),
                 'remember_token' => str_random(10),
                ]
        );
    }
}
