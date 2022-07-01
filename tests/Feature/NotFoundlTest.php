<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Task;
use \Carbon\Carbon;

class NotFoundlTest extends TestCase
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

    public function testShow()
    {
        $response = $this->get(route('task.edit', ['id' => 999]));
        $response->assertStatus(404);
    }

    public function testUpdateShow()
    {
        $data = [
            'status' => 1,
            'title' => "title",
            'description' => "wゑｴ😀𩸽"
        ];

        $response = $this->put(route('task.update', ['id' => 999]), $data);
        $response->assertStatus(404);
    }

    public function testUpdateStatusNotFound()
    {
        $response = $this->delete(route('task.delete', [ 'id' => 999 ]));
        $response->assertStatus(422);
    }
}
