@extends('layouts.header')
@section('title', 'TOP')
@section('content')

<div class="mt-4">
    <h2>客室一覧</h2>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <p class="card-text">客室：シングルルーム</p>
                    <p class="card-text">説明：おひとりさま用のお部屋です</p>
                </div>
            </div>
        </div>
        <div class="col-md-8 mx-auto mt-2">
            <div class="card">
                <div class="card-body">
                    <p class="card-text">客室：ダブルルーム</p>
                    <p class="card-text">説明：おふたりさま用のお部屋です</p>
                </div>
            </div>
        </div>
        <div class="col-md-8 mx-auto mt-2">
            <div class="card">
                <div class="card-body">
                    <p class="card-text">客室：スイートルーム</p>
                    <p class="card-text">説明：ハイクラスなお部屋です</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
