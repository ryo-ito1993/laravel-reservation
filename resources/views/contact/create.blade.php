@extends('layouts.header')
@section('title', 'お問合せ')
@section('content')

<div class="mt-4 mb-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <h2 class="mb-4">お問合せフォーム</h2>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <x-error-messages :$errors />
                </div>
            @endif
            <form action="{{ route('contact.confirm') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">お名前</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">メールアドレス</label>
                    <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}">
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">お問い合わせ内容</label>
                    <textarea class="form-control" id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
                </div>
                <input type="submit" class="btn btn-primary mt-3" value="確認画面へ" onclick="this.disabled=true; this.form.submit();">
            </form>
        </div>
    </div>
</div>

@endsection
