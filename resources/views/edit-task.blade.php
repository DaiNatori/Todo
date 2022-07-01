@extends('layout.layout')

@section('newbutton')
      <div class="d-flex justify-content-end">
          <a class="btn btn-primary" href="{{ route('task.new') }}" role="button">+ Add</a>
      </div>
@endsection

@include('layout.tab-header')

@section('content')
<form method="post" action="{{route('task.update', ['id' => $task->id])}}">
    @method('PUT')
    @csrf

    <!-- タイトル　-->
    <div class="mb-3">
        <label class="form-label">title</label>
        <input name="title" class="form-control" type="text"
            placeholder="Text input" value="{{ old('title') ?? $task->title }}">
        @error('title')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>

    <!-- スタータス選択肢　-->
    <div class="mb-3">
        <label class="form-label">status</label>
        <select name="status" class="form-select">
          <option value="1" @if( (old('status') ?? $task->status ) == 1 ) selected @endif>未着手</option>
          <option value="2" @if( (old('status') ?? $task->status ) == 2 ) selected @endif>着手中</option>
          <option value="3" @if( (old('status') ?? $task->status ) == 3 ) selected @endif>完了</option>
          <option value="4" @if( (old('status') ?? $task->status ) == 4 ) selected @endif>延期</option>
        </select>
    </div>


    <!-- 概要 -->
    <div class="mb-5">
        <label class="form-label">description</label>
        <textarea name="description" class="form-control" type="text"
            placeholder="Text input">{{ old('description') ?? $task->description  }}</textarea>
        @error('description')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>

    <!-- ボタン類 -->
    <div class="d-flex justify-content-end">
        <button class="btn btn-danger me-2" form="delete">Delete</button>
        <button class="btn btn-primary me-2">Submit</button>
        <a class="btn btn-secondary" href="{{route('home') }}">Cancel</a>

    </div>
</form>

<form id="delete" method="POST" action="{{ route('task.delete',['id'=>$task->id]) }}">
    @method('DELETE')
    @csrf
</form>
@endsection