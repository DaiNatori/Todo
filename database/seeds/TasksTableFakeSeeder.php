<?php

use Illuminate\Database\Seeder;
use App\Task;

class TasksTableFakeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Task::class,10)->create();
    }
}
