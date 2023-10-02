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
    <table class="table">
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
