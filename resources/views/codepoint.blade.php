@extends('layout.layout')

@include('layout.tab-header')

@section('content')

コードポイント表示　<br/>

<form method="POST" action="{{route('codepoint')}}">
    @csrf

    <div class="mb-5">
        <label class="form-label">description</label>
        <textarea name="text" class="form-control" type="text"
            placeholder="Text input">{{ $text ?? ""}}</textarea>
    </div>

    <div class="d-flex justify-content-end">

        <button class="btn btn-primary mr-2">Submit</button>

        <a class="btn btn-secondary" href="{{route('home') }}">Cancel</a>
    </div>
</form>
<div>
コードポイント: {{ $codepoint ?? "" }}
</div>
@endsection
