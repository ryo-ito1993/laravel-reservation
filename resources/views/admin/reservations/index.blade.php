@extends('adminlte::page')

@section('title', '予約一覧')

@section('content_header')
    <h1>予約一覧</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#searchForm" aria-expanded="false" aria-controls="searchForm">
        検索フォームを開く/閉じる
    </button>
    <div class="collapse" id="searchForm">
        <div class="card card-body">
            <form action="{{ route('admin.reservations.index') }}" method="GET">
                <div class="mb-3">
                    <input type="text" name="name" id="name" class="form-control" placeholder="名前で検索" value="{{ request('name') }}">
                </div>
                <div class="mb-3">
                    <input type="text" name="email" id="email" class="form-control" placeholder="メールアドレスで検索" value="{{ request('email') }}">
                </div>

                <div class="form-group">
                    <label for="date">予約日</label>
                    <input type="date" name="date" id="date" class="form-control" value="{{  request('date') }}">
                </div>
                <div class="form-group">
                    <select name="plan" id="plan" class="form-control">
                        <option disabled selected value>プランを選択してください</option>
                        @foreach($plans as $plan)
                            <option value="{{ $plan->id }}" {{  request('plan') == $plan->id ? 'selected' : '' }}>{{ $plan->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <select name="room" id="room" class="form-control">
                        <option disabled selected value>部屋タイプを選択してください</option>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}" {{  request('room') == $room->id ? 'selected' : '' }}>{{ $room->type }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <select name="status" id="status" class="form-control">
                        <option disabled selected value>予約状況を選択してください</option>
                        <option value="0" {{ request('status') === "0" ? 'selected' : '' }}>予約済</option>
                        <option value="1" {{ request('status') === "1" ? 'selected' : '' }}>キャンセル</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-secondary">検索</button>
            </form>
        </div>
    </div>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>名前</th>
                <th>メールアドレス</th>
                <th>予約日</th>
                <th>プラン</th>
                <th>部屋タイプ</th>
                <th>予約状況</th>
                <th>詳細</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservations as $reservation)
                <tr>
                    <td>{{ $reservation->id }}</td>
                    <td>{{ $reservation->last_name }} {{ $reservation->first_name }}</td>
                    <td>{{ $reservation->email }}</td>
                    <td>{{ \Carbon\Carbon::parse($reservation->reservation_slot->date)->format('Y年m月d日') }}</td>
                    <td>{{ $reservation->plan->title }}</td>
                    <td>{{ $reservation->reservation_slot->room->type }}</td>
                    <td>
                        <form action="{{ route('admin.reservations.updateStatus', $reservation) }}" method="post">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()">
                                <option value="0" @if($reservation->status == 0) selected @endif>予約済</option>
                                <option value="1" @if($reservation->status == 1) selected @endif>キャンセル</option>
                            </select>
                        </form>
                    </td>
                    <td>
                        <a href="{{ route('admin.reservations.show', $reservation) }}" class="btn btn-primary">詳細</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop
