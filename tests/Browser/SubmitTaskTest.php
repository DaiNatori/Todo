<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Task;

class SubmitTaskTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testCancel()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(route('task.new'))
                    ->clickLink('Cancel')
                    ->assertPathIs('/');
        });
    }

    public function testOldValueDisp()
    {
        $this->browse(function (Browser $browser) {
            //タスク一覧画面からタスク新規登録画面へ遷移
            $browser->visit('/')
            ->clickLink('+ Add')
            ->assertPathIs('/tasks/create')
            //フォームの入力
            ->type('title','タイトル1タイトル1タイトル1タイトル1タイトル1タイトル1タイトル1タイトル12')
            ->type('description', '本文1')
            ->press('Submit')
            //エラー後の再表示の確認
            ->assertPathIs('/tasks/create')
            ->assertInputValue('title', 'タイトル1タイトル1タイトル1タイトル1タイトル1タイトル1タイトル1タイトル12')
            ->assertInputValue('description', '本文1');
        });
    }
}
