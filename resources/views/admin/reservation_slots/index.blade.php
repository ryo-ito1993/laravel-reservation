@extends('adminlte::page')

@section('title', '予約枠一覧')

@section('content_header')
    <h1>予約枠一覧</h1>
@stop

@section('content')
    @if(session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <a href="{{ route('admin.reservation_slots.create') }}" class="btn btn-success mb-3">新規追加</a>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>部屋タイプ</th>
                <th>日付</th>
                <th>予約枠数</th>
                <th>料金</th>
                <th>編集</th>
                <th>削除</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservation_slots as $slot)
                <tr>
                    <td>{{ $slot->id }}</td>
                    <td>{{ $slot->room->type }}</td>
                    <td>{{ $slot->date }}</td>
                    <td>{{ $slot->available_slots }}</td>
                    <td>{{ $slot->price }}</td>
                    <td>
                        <!-- 編集ボタン -->
                        <a href="#" class="btn btn-warning">編集</a>
                    </td>
                    <td>
                        <!-- 削除ボタン -->
                        <form action="{{ route('admin.reservation_slots.destroy', $slot) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">削除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop
