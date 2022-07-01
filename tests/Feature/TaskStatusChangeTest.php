<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Task;
use \Carbon\Carbon;

class TaskStatusChangeTest extends TestCase
{

    use Refreshdatabase;

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

    public function provideStateTestParams()
    {

        return [
            'ステータスが未着手になること' => ['Ready', '2'],
            'ステータスが着手中になること' => ['Doing','3'],
            'ステータスが完了になること' => ['Done', '4'],
            'ステータスが延期になること' => ['notReady', '1'],
        ];
    }
    /**
     * @dataProvider provideStateTestParams
     *
     * @param int $beforeStatus
     * @param int $afterStatus
     */
    public function testUpdateState($beforeStatus,$afterStatus): void
    {
        // 1件のタスクを指定のステータスで作成。
        $task = factory(Task::class)->state($beforeStatus)->create();

        //スタータス更新を行います。
        $response = $this->get(route('task.updateStatus',['id' => $task->id,'afterstatus'=>$afterStatus]) );
        //画面が指定先にリダイレクトされていることを確認
        $response->assertRedirect(route('home'));

        //スタータスの更新が行われたかを確認
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'status' => $afterStatus,
            'created_at' => $task->created_at
        ]);

        //更新日付が新しい日付になったかを確認
        $updatedTask = Task::find($task->id);
        $this->assertGreaterThan(
            $task->updated_at,
            $updatedTask->updated_at,
        );

    }
}
