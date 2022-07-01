<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use DB;

class BasicController extends Controller
{
    public function showClientIp(Request $request) {

        $clientIpAddress = $request->ip();
        return view('show-ip', compact('clientIpAddress'));

    }

    public function showArticle(Request $request,$id) {

        //データベースなどの外部記憶媒体から$idで指定された記事を取得
        $data =['article' => "{$id}の記事です。" ];
        return view('show-article', $data);


    }    

    public function showName(Request $request) {

        $name = $request->name;
        return  $name;

    } 

    public function showTaskA(Request $request) {

        $tasks = DB::table('tasks')->get();
        return view('show-task', compact('tasks'));

    }    


    public function showTaskB(Request $request) {

        $tasks = Task::all();
        return view('show-task', compact('tasks'));

    }  

    public function showTaskC(Request $request) {

        $tasks = DB::select('SELECT * from tasks');
        return view('show-task', compact('tasks'));

    } 
    public function codePoint(Request $request) {

        $text = $request->text;
        $textarray =  preg_split("//u" , $text, -1, PREG_SPLIT_NO_EMPTY);
        $codepoint  = "";
        foreach ( $textarray as $str){
            $codepoint = $str ? $codepoint . sprintf("U+%04X",mb_ord($str)) . "," : "";
        }

        return view('codepoint', compact('codepoint','text'));

    } 

}
