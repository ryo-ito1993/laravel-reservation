@extends('layouts.header')
@section('title', '宿泊プラン一覧')

@section('content')
<div class="container">
    <h2 class="mt-4 mb-4">宿泊プラン一覧</h2>
    <form action="{{ route('plans.index') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="プラン名で検索" value="{{ request('search') }}">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">検索</button>
            </div>
        </div>
    </form>
    <div class="row">
        @foreach($plans as $plan)
        <div class="col-md-4 mb-4">
            <div class="card">
                @if($plan->images->first())
                    <img src="{{ asset('storage/' . $plan->images->first()->image) }}" class="card-img-top" alt="プラン画像">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $plan->title }}</h5>
                    <p class="card-text">{{ Str::limit($plan->description, 100) }}</p>
                    <a href="{{ route('plans.show', $plan) }}" class="btn btn-primary">詳細を見る</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
