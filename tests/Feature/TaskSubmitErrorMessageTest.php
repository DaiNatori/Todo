<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use \Str;
use App\Task;


class TaskSubmitErrorMessageTest extends TestCase
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

    public function testTitleNoTextError(): void
    {
        $data = [
            'status' => 1,
            'title' => '',
            'description' => "description",
        ];
     
        $response = $this->from('/tasks/create')->post('/tasks', $data);

        $response->assertSessionHasErrors(['title' => 'タイトルは必ず指定してください。']);

        $response->assertRedirect('/tasks/create');
    }

    public function testTitleLongError(): void
    {
        $data = [
            'status' => 1,
            'title' => Str::random(41),
            'description' => "description",
        ];
        
        $response = $this->from('/tasks/create')->post('/tasks', $data);

        $response->assertSessionHasErrors(['title' => 'タイトルは、40文字以下で指定してください。']);

        $response->assertRedirect('/tasks/create');
    }

    public function testDescriptionLongError(): void
    {
        $data = [
            'status' => 1,
            'title' => 'title',
            'description' => Str::random(201),
        ];

        $response = $this->from('/tasks/create')->post('/tasks', $data);

        $response->assertSessionHasErrors(['description' => '概要は、200文字以下で指定してください。']);
        // $response->assertSessionHasErrors('description');

        $response->assertRedirect('/tasks/create');
    }
}