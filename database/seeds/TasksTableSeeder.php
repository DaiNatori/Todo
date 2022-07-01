<?php

use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tasks')->insert([
            [
                     'title' => 'fortniteで櫓の建築'
                    , 'status' => 1
                    , 'description' => '秒で3段の櫓を作る'
            ],
            [
                     'title' => 'fortniteでチャージショットガンの撃ち方'
                    , 'status' => 1
                    , 'description' => 'チャージショットガンを撃った後に壁を作る'
            ]
        ]);
    }
}
