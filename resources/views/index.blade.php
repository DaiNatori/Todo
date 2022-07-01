@extends('layout.layout')

@section('newbutton')
      <div class="d-flex justify-content-end">
          <a class="btn btn-primary" href="{{ route('task.new') }}" role="button">+ Add</a>
      </div>
@endsection

@include('layout.tab-header')

@section('content')
<ul class="list-group">
    @foreach ($tasks as $task)
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <a href="{{ route('task.edit',['id' => $task->id]) }}" dusk="{{ 'edit-' . $task->id }}" >{{ $task->status_name }}-{{ $task->title }}</a>
        <div>
            <a class="btn btn-primary btn-sm mr-1" role="button" href="{{ route('task.updateStatus',['id' => $task->id,'afterstatus'=>1]) }}">
                未着手
            </a>
            <a class="btn btn-primary btn-sm mr-1" role="button" href="{{ route('task.updateStatus',['id' => $task->id,'afterstatus'=>2]) }}">
                着手中
            </a>
            <a class="btn btn-primary btn-sm mr-1" role="button" href="{{ route('task.updateStatus',['id' => $task->id,'afterstatus'=>3]) }}">
                完了
            </a>
            <a class="btn btn-primary btn-sm" role="button" href="{{ route('task.updateStatus',['id' => $task->id,'afterstatus'=>4]) }}">
                延期
            </a>
        </div>
    </li>
    @endforeach
</ul>
@endsection