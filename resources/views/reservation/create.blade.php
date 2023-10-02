@extends('layouts.header')
@section('title', '予約フォーム')
@section('content')

<div class="mt-4 mb-4">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <h2 class="mb-4">予約フォーム</h2>
            <div class="border border-1 mb-4 p-3 d-flex col-10">
                <div class="me-3">
                    <img src="{{ asset('storage/' . $plan->images[0]->image) }}" alt="Plan Image" class="img-fluid" style="height: 90px; width: 120px object-fit: cover; ">
                </div>
                <div  class="ml-3">
                    <h6>予約日：{{ \Carbon\Carbon::parse($slot->date)->format('Y年m月d日') }}</h6>
                    <h6>プラン：{{ $plan->title }}</h6>
                    <h6>部屋タイプ：{{ $slot->room->type }}</h6>
                    <div class="mt-1">
                        <a href="{{ route('reservation.calender', ['plan' => $plan, 'room' => $slot->room]) }}">空席確認へ戻る</a>
                    </div>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <x-error-messages :$errors />
                </div>
            @endif
            <form action="{{ route('reservation.confirm', ['plan' => $plan, 'slot' => $slot]) }}" method="POST">
                @csrf
                <div class="form-group row mb-3">
                    <div  class="col-2">
                        <label for="last_name" class="form-label">お名前</label>
                    </div>
                    <div class="col-4">
                        <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}">
                    </div>
                    <div class="col-4">
                        <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col-2">
                        <label for="email" class="form-label">メールアドレス</label>
                    </div>
                    <div class="col-8">
                        <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col-2">
                        <label for="address" class="form-label">住所</label>
                    </div>
                    <div class="col-8">
                        <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col-2">
                        <label for="phone_number" class="form-label">電話番号</label>
                    </div>
                    <div class="col-8">
                        <input type="tel" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number') }}">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col-2">
                        <label for="message" class="form-label">メッセージ</label>
                    </div>
                    <div class="col-8">
                        <textarea class="form-control" id="message" name="message" rows="3">{{ old('message') }}</textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="offset-3 col-5">
                        <input type="submit" class="btn btn-primary btn-lg mt-3" style="width: 100%" value="確認画面へ" onclick="this.disabled=true; this.form.submit();">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
