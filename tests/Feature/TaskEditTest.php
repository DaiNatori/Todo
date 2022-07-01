<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Task;
use \Carbon\Carbon;

class TaskEditTest extends TestCase
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

    public function provideTitleTestParams()
    {
        $whiteTexts = \IntlChar::chr("\u{3000}") . \IntlChar::chr("\u{2007}");

        return [
            'タイトル必須OK' => ["title", true],
            'タイトル必須NULL' => [null,false],
            'タイトル必須未入力' => ["", false],
            'タイトル必須半角空白' => [" ", false],
            'タイトル必須全角空白' => ["　", false],
            'タイトル必須空文字' => [ "{$whiteTexts}", false],
        ];
    }

    /**
     * @dataProvider provideTitleTestParams
     *
     * @param mixed $data
     * @param mixed $expected
     */
    public function testPutTaskTitle_failed($title, $expected): void
    {
        $data = [
            'status' => 1,
            'title' => $title,
            'description' => "wゑｴ😀𩸽",
        ];

        $response = $this->from('/tasks/create')->post('/tasks', $data);

        if ($expected) {
            $response->assertSessionDoesntHaveErrors('title');
            $response->assertRedirect('/');
        } else {
            $response->assertSessionHasErrors('title');
            //画面が指定先にリダイレクトされていることを確認
            $response->assertRedirect('/tasks/create');
        }
    }

    //テストデータを渡すデータプロバイダ用の関数
    public function provideTitleLengthTestParams()
    {
        // 半角空白　\IntlChar::chr("\u{0020}")
        // 全角空白　\IntlChar::chr("\u{3000}")
        // 図形間隔　\IntlChar::chr("\u{2007}")
        // タブ文字　\IntlChar::chr("\u{0009}")

        $whiteChar = \IntlChar::chr("\u{0020}");
        $whiteText = \IntlChar::chr("\u{3000}"). \IntlChar::chr("\u{2007}").\IntlChar::chr("\u{0009}");

        //半角、UTF16のサロゲート文字、UTF8の4バイト文字、半角カタカナ、絵文字などを含めた文字列
        $text = str_repeat("wゑｴ😀𩸽", 8);
        $halftext = str_repeat("wゑｴ😀𩸽", 4);
        echo "{$text}{$whiteText}{$whiteText}";

            return [
                '41文字（40文字超過NG）' => ["{$text}a", false],
                '40文字（40文字以内OK）' => ["{$text}", true],
                '39文字（40文字以内OK）' => ["{$halftext}123456789", true],
                '空白文字＋40文字' => ["{$whiteChar}{$text}", true],
                '40文字＋空白文字' => ["{$text}{$whiteChar}", true],
                '空白2文字＋40文字' => ["{$whiteChar}{$whiteChar}{$text}", true],
                '40文字＋空白2文字' => ["{$text}{$whiteChar}{$whiteChar}", true],
                '20文字＋空白文字＋20文字' => ["{$halftext}{$whiteText}{$halftext}", false],
                '様々な空白文字＋40文字' => ["{$whiteText}{$text}", true],
            ];
    }

    /**
     * @dataProvider provideTitleLengthTestParams
     *
     * @param mixed $title
     * @param boolean $expected
     */
    public function testPutTaskTitle_length($title, $expected): void
    {

        $data = [
            'status' => 1,
            'title' => $title,
            'description' => "description",
        ];

        //post で　送信先とdata を指定し、レスポンス（処理結果）を取得します。
        $response = $this->from('/tasks/create')->post('/tasks', $data);

        if ($expected) {
            $response->assertSessionDoesntHaveErrors('title');
            $response->assertRedirect('/');
        } else {
            $response->assertSessionHasErrors('title');
            $response->assertRedirect('/tasks/create');
        }
    }

    public function provideDescLengthTestParams()
    {
        // 半角空白　\IntlChar::chr("\u{0020}")
        // 全角空白　\IntlChar::chr("\u{3000}")
        // 図形間隔　\IntlChar::chr("\u{2007}")
        // タブ文字　\IntlChar::chr("\u{0009}")
        // Carriage return　\IntlChar::chr("\u{000D}")
        // Line feed　\IntlChar::chr("\u{000A}")
        // Vertical tab　\IntlChar::chr("\u{000B}")
        // Form feed　\IntlChar::chr("\u{000C}")
        // Next line　\IntlChar::chr("\u{0085}")
        // Line separator　\IntlChar::chr("\u{2028}")
        // Paragraph separator　\IntlChar::chr("\u{2029}")

        $whiteChar = \IntlChar::chr("\u{0020}");
        $whiteText = \IntlChar::chr("\u{3000}"). \IntlChar::chr("\u{2007}"). \IntlChar::chr("\u{0009}");
        $escapeText = \IntlChar::chr("\u{000D}"). \IntlChar::chr("\u{000A}"). \IntlChar::chr("\u{000B}"). \IntlChar::chr("\u{000C}"). \IntlChar::chr("\u{0085}"). \IntlChar::chr("\u{2028}"). \IntlChar::chr("\u{2029}");

        //半角、UTF16のサロゲート文字、UTF8の4バイト文字、半角カタカナ、絵文字などを含めた文字列
        $text = str_repeat("wゑｴ😀𩸽", 40); // 200文字
        $halftext = str_repeat("wゑｴ😀𩸽", 20); // 100文字
        $quatertext = str_repeat("wゑｴ😀𩸽", 10); // 50文字
        $onefifthquatertext = str_repeat("wゑｴ😀𩸽", 2); // 10文字
        $serialnumbers = 123456789; // 9文字
        echo "{$text}{$whiteText}{$whiteText}";

            return [
                '201文字（200文字超過NG）' => ["{$text}a", false],
                '200文字（200文字以内OK）' => ["{$text}", true],
                '199文字（200文字以内OK）' => ["{$halftext}{$quatertext}{$onefifthquatertext}{$onefifthquatertext}{$onefifthquatertext}{$onefifthquatertext}{$serialnumbers}", true],
                '空白文字＋200文字' => ["{$whiteChar}{$text}", true],
                '200文字＋空白文字' => ["{$text}{$whiteChar}", true],
                '空白2文字＋200文字' => ["{$whiteChar}{$whiteChar}{$text}", true],
                '200文字＋空白2文字' => ["{$text}{$whiteChar}{$whiteChar}", true],
                '100文字＋空白文字＋100文字' => ["{$halftext}{$whiteText}{$halftext}", false],
                '様々な空白文字＋200文字' => ["{$whiteText}{$text}", true],
                '100文字＋改行文字＋100文字' => ["{$halftext}{$escapeText}{$halftext}", false],
                '改行文字＋200文字' => ["{$escapeText}{$text}", true],
            ];
    }

    /**
     * @dataProvider provideDescLengthTestParams
     *
     * @param mixed $title
     * @param boolean $expected
     */
    public function testPutDesc_length($description, $expected): void
    {

        $data = [
            'status' => 1,
            'title' => "title",
            'description' => $description,
        ];

        //post で　送信先とdata を指定し、レスポンス（処理結果）を取得する
        $response = $this->from('/tasks/create')->post('/tasks', $data);

        if ($expected) {
            $response->assertSessionDoesntHaveErrors('description');
            $response->assertRedirect('/');
        } else {
            $response->assertSessionHasErrors('description');
            $response->assertRedirect('/tasks/create');
        }
    }

    public function testStore(): void
    {
        //作成日付と更新日付を特定日にするために設定
        $testdate = new Carbon('2022-01-01 23:59:59');
        Carbon::setTestNow($testdate);

        $data = [
        'status' => 1,
        'title' => "title",
        'description' => "wゑｴ😀𩸽"
        ];

        //登録前に同じデータがないことを確認する
        $this->assertDatabaseMissing('tasks', $data);

        $response = $this->post('/tasks', $data);

        //更新日付と作成日付が登録されていることを確認するために配列を追加
        $expected =  $data  + array('created_at'=>$testdate,'updated_at'=>$testdate);

        //登録が正しくされたことを確認する
        $this->assertDatabaseHas('tasks', $expected);

        //画面が指定先にリダイレクトされていることを確認
        $response->assertRedirect('/');

        //テスト日付をリセット
        Carbon::setTestNow();
    }

    public function testShow(): void
    {
        $readytask = factory(Task::class)->state('Ready')->create();
        factory(Task::class,1)->state('Doing')->create();
        factory(Task::class,1)->state('Done')->create();
        factory(Task::class,1)->state('notReady')->create();

        $id = $readytask->id;
        $response = $this->get("/tasks/{$id}");
        $response->assertStatus(200);
        $response->assertViewHas('task', $readytask);
    }

    public function testUpdate(): void
    {
        //1件のタスクを作って取得
        $editTask = factory(Task::class)->state('Ready')->create();
        factory(Task::class,1)->state('Doing')->create();
        factory(Task::class,1)->state('Done')->create();
        factory(Task::class,1)->state('notReady')->create();

        //更新データを作成
        $data = [
            'id' => $editTask->id,
            'status' => 2,
            'title' => "update title",
            'description' => "update description"
        ];

        //PUTでリクエストを送信
        $response = $this->from("/tasks/$editTask->id")->put("/tasks/$editTask->id", $data);

        //更新データと同じものがデータベースにあることを確認
        $this->assertDatabaseHas('tasks', $data);

        //更新したタスクを取得（タイムスタンプ系の照合をするため）
        $updatedTask = Task::find($editTask->id);

        //作成日が変更されていないことを確認
        $this->assertEquals(
            $editTask->created_at,
            $updatedTask->created_at,
        );

        //更新日が更新されていることを確認
        $this->assertGreaterThan(
            $editTask->updated_at,
            $updatedTask->updated_at,
        );

        //画面が指定先にリダイレクトされていることを確認
        $response->assertRedirect(route('home'));
    }
}