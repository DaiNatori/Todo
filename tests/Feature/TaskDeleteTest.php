<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Task;
use \Carbon\Carbon;

class TaskDeleteTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testDelete()
    {
        factory(Task::class,1)->state('Ready')->create();
        factory(Task::class,1)->state('Doing')->create();
        factory(Task::class,1)->state('Done')->create();
        $task = factory(Task::class)->state('notReady')->create();

        $data = [
            'id' => $task->id,
        ];

        //databaseに該当のものが存在することを確認
        $this->assertDatabaseHas('tasks', $data);

        $response = $this->delete(route('task.delete',$data));
        $response->assertRedirect('/');

        //databaseに該当のものが存在しないことを確認
        $this->assertDatabaseMissing('tasks', $data);
    }
}
