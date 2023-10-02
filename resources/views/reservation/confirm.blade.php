@extends('layouts.header')
@section('title', '予約確認画面')
@section('content')

<div class="mt-4 mb-4">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <h2 class="mb-4">予約内容確認</h2>
            <div class="border border-1 mb-4 p-3 d-flex col-10">
                <div class="me-3">
                    <img src="{{ asset('storage/' . $plan->images[0]->image) }}" alt="Plan Image" class="img-fluid" style="height: 90px; width: 120px object-fit: cover; ">
                </div>
                <div  class="ml-3">
                    <h6>予約日：{{ \Carbon\Carbon::parse($slot->date)->format('Y年m月d日') }}</h6>
                    <h6>プラン：{{ $plan->title }}</h6>
                    <h6>部屋タイプ：{{ $slot->room->type }}</h6>
                </div>
            </div>
            <table class="table border col-10">
                <tr>
                    <th class="table-light" style="width: 20%;">名前</th>
                    <td style="width: 40%;">{{ $inputs['last_name'] }}</td>
                    <td style="width: 40%;">{{ $inputs['first_name'] }}</td>
                </tr>
                <tr>
                    <th class="table-light">メールアドレス</th>
                    <td colspan="2">{{ $inputs['email'] }}</td>
                </tr>
                <tr>
                    <th class="table-light">住所</th>
                    <td colspan="2">{{ $inputs['address'] }}</td>
                </tr>
                <tr>
                    <th class="table-light">電話番号</th>
                    <td colspan="2">{{ $inputs['phone_number'] }}</td>
                </tr>
                <tr>
                    <th class="table-light">メッセージ</th>
                    <td colspan="2" style="white-space: pre-wrap;">{{ $inputs['message'] }}</td>
                </tr>
            </table>

            <form action="{{ route('reservation.send', ['plan' => $plan, 'slot' => $slot]) }}" method="POST">
                @csrf
                <input type="hidden" name="last_name" value="{{ $inputs['last_name'] }}">
                <input type="hidden" name="first_name" value="{{ $inputs['first_name'] }}">
                <input type="hidden" name="email" value="{{ $inputs['email'] }}">
                <input type="hidden" name="address" value="{{ $inputs['address'] }}">
                <input type="hidden" name="phone_number" value="{{ $inputs['phone_number'] }}">
                <input type="hidden" name="message" value="{{ $inputs['message'] }}">
                <div class="row">
                    <div class="offset-3 col-5">
                        <button type="submit" name="action" value="submit" class="btn btn-primary btn-lg mt-3" style="width: 100%">
                            送信する
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="offset-3 col-5">
                        <button type="submit" name="action" value="back" class="btn btn-secondary btn-lg mt-3" style="width: 100%">
                            修正する
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
