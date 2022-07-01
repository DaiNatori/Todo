<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Task;
use \Carbon\Carbon;

class TaskTabChangeTest extends TestCase
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

    public function testReadyListOnly()
    {
        factory(Task::class,5)->state('Ready')->create();
        factory(Task::class,1)->state('Doing')->create();
        factory(Task::class,1)->state('Done')->create();
        factory(Task::class,1)->state('notReady')->create();

        $response = $this->get(route('tasklist', ['tabindex' => 1]));
        $response->assertStatus(200);
        $response->assertViewHas('tasks');
        $tasks = $response->original['tasks'];
        $this->assertEquals(5, count($tasks));
    }
    
    public function testReadyDoingOnly()
    {
        factory(Task::class,1)->state('Ready')->create();
        factory(Task::class,5)->state('Doing')->create();
        factory(Task::class,1)->state('Done')->create();
        factory(Task::class,1)->state('notReady')->create();

        $response = $this->get(route('tasklist', ['tabindex' => 2]));
        $response->assertStatus(200);
        $response->assertViewHas('tasks');
        $tasks = $response->original['tasks'];
        $this->assertEquals(5, count($tasks));
    }
    
    public function testReadyDoneOnly()
    {
        factory(Task::class,1)->state('Ready')->create();
        factory(Task::class,1)->state('Doing')->create();
        factory(Task::class,5)->state('Done')->create();
        factory(Task::class,1)->state('notReady')->create();

        $response = $this->get(route('tasklist', ['tabindex' => 3]));
        $response->assertStatus(200);
        $response->assertViewHas('tasks');
        $tasks = $response->original['tasks'];
        $this->assertEquals(5, count($tasks));
    }
    
    public function testReadynotReadyOnly()
    {
        factory(Task::class,1)->state('Ready')->create();
        factory(Task::class,1)->state('Doing')->create();
        factory(Task::class,1)->state('Done')->create();
        factory(Task::class,5)->state('notReady')->create();

        $response = $this->get(route('tasklist', ['tabindex' => 4]));
        $response->assertStatus(200);
        $response->assertViewHas('tasks');
        $tasks = $response->original['tasks'];
        $this->assertEquals(5, count($tasks));
    }
}
