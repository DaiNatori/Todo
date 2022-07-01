<?php

namespace Tests\Feature;

use Mockery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Task;

class AbnormalTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // $this->withoutExceptionHandling();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    public function testStore()
    {
        $mock = Mockery::mock('overload:App\Task');
        $mock->shouldReceive('fill')->once()->andReturn(true);
        $mock->shouldReceive('save')->once()->andReturn(false);

        $data = [
            'status' => 1,
            'title' => "title",
            'description' => "description"
        ];

        $response = $this->post('/tasks', $data);
        $response->assertStatus(422);
    }

    public function testUpdate()
    {
        $taskmodel = new class {
            public function fill($array)
            {
                return true;
            }
            public function save()
            {
                return false;
            }
        };

        $mock = Mockery::mock('overload:App\Task');
        $mock->shouldReceive('FindOrFail')->once()->andReturn($taskmodel);

        $data = [
            'status' => 1,
            'title' => "title",
            'description' => "wゑｴ😀𩸽"
        ];

        $response = $this->put("/tasks/1", $data);
        $response->assertStatus(422);
    }

    public function testUpdateStatus()
    {

        $taskmodel = new class {
            public $status;

            public function save()
            {
                return false;
            }
        };

        $mock = Mockery::mock('overload:App\Task');
        $mock->shouldReceive('FindOrFail')->once()->andReturn($taskmodel);

        $response = $this->get(route('task.updateStatus', ['id' => 1,'afterstatus' => 4]));
        $response->assertStatus(422);
    }

    public function testDelete()
    {
        $mock = Mockery::mock('overload:App\Task');
        $mock->shouldReceive('destroy')->once()->andReturn(0);
        $response = $this->delete(route('task.delete', [ 'id' => 999 ]));
        $response->assertStatus(422);
    }
}
