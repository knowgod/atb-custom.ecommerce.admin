<?php

use Illuminate\Database\Seeder;
use App\Models\Users\Entities\User;

class UsersTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        for($i = 0; $i <= 50; $i++){
            $user = new User();
            $faker = Faker\Factory::create();
            $user->setEmail($faker->email)
                    ->setFirstname($fname = $faker->firstName)
                    ->setLastname($lname =  $faker->lastName)
                    ->setFullname($fname . ' ' . $lname)
                    ->setRegisterSource('manual')
                    ->setPassword(bcrypt(str_random(10)));
            $user->setRememberToken(str_random(10));
            $user->save();
        }
        try{
            $user = new User();
            $user->setEmail('atbadmin@atypicalbrands.com')
                    ->setFirstname('Atypical')
                    ->setLastname('Admin')
                    ->setFullname('Atypical Admin')
                    ->setRegisterSource('manual')
                    ->setPassword(bcrypt('abcABC123'));
            $user->save();
        }catch (\Exception $e){
            echo $e->getMessage();
            return;
        }
    }
}
