@extends('adminlte::page')

@section('title', 'お問い合わせ詳細')

@section('content_header')
    <h1>予約詳細</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <p class="card-text">ID：{{ $reservation->id }}</p>
                        <p class="card-text">名前：{{ $reservation->last_name }} {{ $reservation->first_name }}</p>
                        <p class="card-text">メールアドレス：{{ $reservation->email }}</p>
                        <p class="card-text">住所：{{ $reservation->address }}</p>
                        <p class="card-text">電話番号：{{ $reservation->phone_number }}</p>
                        @if ($reservation->message)
                            <p>メッセージ：</p>
                            <p style="white-space: pre-wrap;">{{$reservation->message}}</p>
                        @endif
                        <p class="card-text">予約プラン：{{ $reservation->plan->title }}</p>
                        <p class="card-text">部屋タイプ：{{ $reservation->reservation_slot->room->type }}</p>
                        <p class="card-text">予約日{{ \Carbon\Carbon::parse($reservation->reservation_slot->date)->format('Y年m月d日') }}</p>


                        <p class="card-text">予約状況：
                            <form action="{{ route('admin.reservations.updateStatus', $reservation) }}" method="post">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()">
                                    <option value="0" @if($reservation->status == 0) selected @endif>予約済</option>
                                    <option value="1" @if($reservation->status == 1) selected @endif>キャンセル</option>
                                </select>
                            </form>
                        </p>
                        <p class="card-text">メモ：{{ $reservation->note }}</p>
                        <form action="{{ route('admin.reservations.updateNote', $reservation) }}" method="post">
                            @csrf
                            @method('PATCH')
                            <input type="text" name="note" class="form-control" value="{{ $reservation->note }}">
                            <button type="submit" class="btn btn-primary mt-2">メモを更新</button>
                        </form>
                    </div>
                </div>
                <a href="{{ route('admin.reservations.index') }}" class="btn btn-secondary mt-3">戻る</a>
            </div>
        </div>
    </div>
@stop
