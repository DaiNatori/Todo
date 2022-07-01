<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Task;

class EditTaskTest extends DuskTestCase
{

    use DatabaseMigrations;

    // /**
    //  * A Dusk test example.
    //  *
    //  * @return void
    //  */
    // public function testExample()
    // {
    //     $this->browse(function (Browser $browser) {
    //         $browser->visit('/')
    //                 ->assertSee('Laravel');
    //     });
    // }

    // 選択したタスクの内容が表示されること
    public function testTransition()
    {
        $editTask = factory(Task::class)->state('Ready')->create();
        factory(Task::class, 1)->state('Doing')->create();
        factory(Task::class, 1)->state('Done')->create();
        factory(Task::class, 1)->state('notReady')->create();
        
        $this->browse(function ($browser) use ($editTask) {
            $browser->visit(route('home'))
                    ->click('@edit-'. $editTask->id)
                    ->assertPathIs('/tasks/1');
        });
    }

    // エラー時に前回入力した内容が表示されること
    public function testOldValueDisp()
    {

        $editTask = factory(Task::class)->state('Ready')->create();
        factory(Task::class, 1)->state('Doing')->create();
        factory(Task::class, 1)->state('Done')->create();
        factory(Task::class, 1)->state('notReady')->create();

        $this->browse(function ($browser) use ($editTask) {
            $browser->visit(route('home'))
                    ->click('@edit-' . $editTask->id)
                    //フォームの入力
                    ->type('title', 'タイトル1タイトル1タイトル1タイトル1タイトル1タイトル1タイトル1タイトル12')
                    ->type('description', '本文1')
                    ->select('status', 4)
                    ->press('Submit')
                    //エラー後の再表示の確認
                    ->assertPathIs('/tasks/' . $editTask->id)
                    ->assertInputValue('title', 'タイトル1タイトル1タイトル1タイトル1タイトル1タイトル1タイトル1タイトル12')
                    ->assertSelected('status', 4)
                    ->assertInputValue('description', '本文1');
        });
    }

    // cancelで元の画面に戻ること
    public function testCancel()
    {


    $editTask = factory(Task::class)->state('Ready')->create();
    factory(Task::class, 1)->state('Doing')->create();
    factory(Task::class, 1)->state('Done')->create();
    factory(Task::class, 1)->state('notReady')->create();

    $this->browse(function ($browser) use ($editTask) {
        $browser->visit(route('task.edit', ['id' => $editTask->id]))
                ->clickLink('Cancel')
                ->assertPathIs('/');
    });
    }
}
