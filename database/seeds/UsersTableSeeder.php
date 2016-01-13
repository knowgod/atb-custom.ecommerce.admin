<?php

use Illuminate\Database\Seeder;
use App\Models\Users\Entities;

class UsersTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        factory(App\Models\Users\Entities\User::class, 50)->create();

        //create super admin (kind of)
        App\Models\Users\Entities\User::create(
                ['firstname'      => "Atypical",
                 'lastname'       => "SuperUser",
                 'email'          => 'vyatsyuk@atypicalbrands.com',
                 'password'       => bcrypt('abcABC123'),
                 'remember_token' => str_random(10),
                ]
        );
    }
}
