<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Task;

class TodoListsTest extends DuskTestCase
{

    use DatabaseMigrations;

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/') //一覧画面に移動
                    ->clickLink('+ Add') // 一覧画面で新規作成リンクをクリック
                    ->assertPathIs('/tasks/create'); // 「タスク新規登録」というテキストが含まれていることを確認
            });
    }
}
