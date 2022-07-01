<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Task;

class TaskControllerTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    // public function testExample()
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    public function testReadyListOnly() //表示されたタスクの件数が正しいこと
    {
        factory(Task::class,5)->state('Ready')->create();
        factory(Task::class,1)->state('Doing')->create();
        factory(Task::class,1)->state('Done')->create();
        factory(Task::class,1)->state('notReady')->create();

         
         $response = $this->get("/");   //homeにアクセスしていること
         $response->assertStatus(200);  //レスポンスのステータスコードが200であること
         $response->assertViewHas('tasks'); //レスポンスのVIEWに配列のtasksが含まれること
         $tasks = $response->original['tasks']; //レスポンスからtasksの配列を取得して、

         $this->assertEquals(5, count($tasks)); //その結果が5件であること
    }

    public function testReadyListAll()  //ステータスが未着手のタスクのみ表示されていること
    {
        factory(Task::class,5)->state('Ready')->create();
        factory(Task::class,1)->state('Doing')->create();
        factory(Task::class,1)->state('Done')->create();
        factory(Task::class,1)->state('notReady')->create();

         $response = $this->get("/");
         $response->assertStatus(200);

         $response->assertViewHas('tasks', function ($tasks) {
             foreach ($tasks as $task) {
                 if ($task->status !== 1) {
                     return false;
                 }
             }
             return true;
         });
    }

    public function testReadyListNone() //未着手のデータがないときはリストが空で表示される 
    {
        factory(Task::class,5)->state('Ready')->create();
        factory(Task::class,1)->state('Doing')->create();
        factory(Task::class,1)->state('Done')->create();
        factory(Task::class,1)->state('notReady')->create();

         $response = $this->get("/");
         $response->assertStatus(200);

         $response->assertViewHas('tasks', null);
    }

    public function testListNone()  //タスクテーブルにレコードがない場合は空で表示されること
    {
        $response = $this->get("/");
        $response->assertStatus(200);

        $response->assertViewHas('tasks', null);

    }
}