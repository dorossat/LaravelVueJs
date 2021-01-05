<?php

use Illuminate\Database\Seeder;
use App\Activity;
class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = App\User::all();

        if($users->count() == 0){
            $this->command->info("Please creat some users !");
            return;
        }

        $number_activities = (int)$this->command->ask("How many activities you want generate ?",50);

        factory(Activity::class, $number_activities)->make()->each(function($activity) use ($users)
        {
            $activity->user_id = $users->random()->id;
            $activity->save();
        }); // generate 50 posts
    }
}
