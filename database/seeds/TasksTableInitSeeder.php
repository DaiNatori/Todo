<?php

use Illuminate\Database\Seeder;

class TasksTableInitSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('tasks')->delete();
        
        \DB::table('tasks')->insert(array (
            0 => 
            array (
                // 'id' => 1,
                'title' => 'bitcoinの半減期を調べる',
                'status' => 1,
                'description' => 'bitcoinの半減期と価格の相関性を調べる',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                // 'id' => 2,
                'title' => 'サンフランシスコ旅行',
                'status' => 1,
                'description' => 'サンノゼ空港からパロ・アルトへの行き方を調べる',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                // 'id' => 3,
                'title' => 'アクアパッツァ',
                'status' => 1,
                'description' => '再来週の食事会のためにアクアパッツァの作り方を学ぶ',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                // 'id' => 4,
                'title' => 'サンフランシスコ行きの航空券',
                'status' => 1,
                'description' => '羽田からサンノゼ空港行きのチケットを予約',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
    }
}