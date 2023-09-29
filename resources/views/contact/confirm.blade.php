@extends('layouts.header')
@section('title', 'お問合せ内容確認')
@section('content')

<div class="mt-4 mb-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <h2 class="mb-4">お問合せ内容確認</h2>
            <div class="card">
                <div class="card-body">
                    <div class="mb-3 card-text">
                        <label class="form-label">お名前</label>
                        <p>{{ $inputs['name'] }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">メールアドレス</label>
                        <p>{{ $inputs['email'] }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">お問い合わせ内容</label>
                        <div style="white-space: pre-wrap;">{{$inputs['message']}}</div>
                    </div>
                </div>
            </div>
            <form action="{{ route('contact.send') }}" method="POST">
                @csrf
                <input type="hidden" name="name" value="{{ $inputs['name'] }}">
                <input type="hidden" name="email" value="{{ $inputs['email'] }}">
                <input type="hidden" name="message" value="{{ $inputs['message'] }}">
                <button type="submit" name="action" value="submit" class="btn btn-primary mt-3 mr-2">
                    送信する
                </button>
                <button type="submit" name="action" value="back" class="btn btn-secondary mt-3">
                    修正する
                </button>
            </form>
        </div>
    </div>
</div>

@endsection
