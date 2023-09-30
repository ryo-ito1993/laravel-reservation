@extends('adminlte::page')

@section('title', 'プラン詳細')

@section('content_header')
    <h1>プラン詳細</h1>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <p class="card-text">ID：{{ $plan->id }}</p>
                        <p class="card-text">タイトル：{{ $plan->title }}</p>
                        <p class="card-text">説明：{{ $plan->description }}</p>
                        <p class="card-text">料金：{{ $plan->price }}</p>
                        <p>画像：</p>
                        @foreach($plan->images as $image)
                            <img src="{{ asset('storage/' . $image->image) }}" alt="Plan Image" class="img-fluid mb-2">
                        @endforeach
                    </div>
                </div>
                <a href="{{ route('admin.plans.index') }}" class="btn btn-secondary mt-3">戻る</a>
            </div>
        </div>
    </div>
@stop
