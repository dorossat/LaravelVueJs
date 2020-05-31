<?php

use Illuminate\Database\Seeder;

class UsersTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $number_users = (int)$this->command->ask("How many user you want generate ?",10);
        factory(App\User::class, $number_users)->create(); // generate 10 users
    }
}
