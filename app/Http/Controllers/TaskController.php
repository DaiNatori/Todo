<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($tabindex = '1')
    {
        $tasks = Task::Where("status",$tabindex)->get();
        return view('index', compact('tasks','tabindex'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create-task');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['max:40','required'],
            'description' => ['max:200']
        ]);

        $task = new Task();
        $task->fill($request->all());
        $task->status = 1;

        $result = $task->save();
        // $task->save();
        if (!$result) {
            abort(422);
        }

        return redirect(route('home'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::FindOrFail($id);
        // viewを生成する必要あり？
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task $task
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        // $task = Task::find($id);
        $task = Task::FindOrFail($id);
        return view('edit-task', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(int $id,Request $request)
    {

        $request->validate([
            'title' => ['max:40','required'],
            'description' => ['max:200']
        ]);

        // $task = Task::find($id);
        $task = Task::FindOrFail($id);
        $task->fill($request->all());
        // $task->save();
        if (!$task->save()) {
            abort(422, 'fail update.');
        }
        return redirect(route('home'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $success=Task::destroy($id);
        $deleteRows = Task::destroy($id);
        if ($deleteRows < 1) {
            abort(422, 'fail destroy.');
        }
        return redirect(route('home'));
    }

    public function updateStatus($id,$afterStatus)
    {
        // $task = Task::find($id);
        $task = Task::FindOrFail($id);
        $task->status = $afterStatus;
        // $task->save();
        if (!$task->save()) {
            abort(422, 'fail update.');
        }

        return redirect(route('home'));
    }
}