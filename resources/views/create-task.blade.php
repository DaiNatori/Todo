@extends('layout.layout')

@section('newbutton')
      <div class="d-flex justify-content-end">
          <a class="btn btn-primary" href="{{ route('task.new') }}" role="button">+ Add</a>
      </div>
@endsection

@include('layout.tab-header')

@section('content')
<form method="POST" action="{{route('task.submit')}}">
    @csrf
    <div class="mb-3">
        <label class="form-label">title</label>
        <input name="title" class="form-control" type="text"
            placeholder="Text input" value="{{ old('title') }}">
        @error('title')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror

    </div>

    <div class="mb-5">
        <label class="form-label">description</label>
        <input name="description" class="form-control" type="text"
            placeholder="Text input" value="{{ old('description') }}">
        @error('description')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-flex justify-content-end">

        <button class="btn btn-primary me-2">Submit</button>

        <a class="btn btn-secondary" href="{{route('home') }}">Cancel</a>
    </div>
</form>
@endsection