@extends('adminlte::page')

@section('title', 'プラン編集')

@section('content_header')
    <h1>プラン編集</h1>
@stop

@section('content')
    <form action="{{ route('admin.plans.update', $plan) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @if ($errors->any())
            <div class="alert">
                <x-error-messages :$errors />
            </div>
        @endif

        <div class="mb-3">
            <label for="title" class="form-label">タイトル:</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $plan->title) }}">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">説明:</label>
            <textarea name="description" id="description" class="form-control">{{ old('description', $plan->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">料金:</label>
            <input type="number" name="price" id="price" class="form-control" value="{{ old('price', $plan->price) }}">
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">画像:</label>
            @foreach($plan->images as $image)
                <img src="{{ asset('storage/' . $image->image) }}" alt="Plan Image" width="100">
            @endforeach
            <input type="file" name="image[]" id="image" class="form-control" multiple>
        </div>

        <button type="submit" class="btn btn-primary">更新</button>
    </form>
@stop
