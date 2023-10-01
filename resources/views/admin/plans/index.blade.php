@extends('adminlte::page')

@section('title', 'プラン一覧')

@section('content_header')
    <h1>プラン一覧</h1>
@stop

@section('content')
    @if(session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <a href="{{ route('admin.plans.create') }}" class="btn btn-success mb-3">新規追加</a>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>タイトル</th>
                <th>料金</th>
                <th>詳細</th>
                <th>編集</th>
                <th>削除</th>
            </tr>
        </thead>
        <tbody>
            @foreach($plans as $plan)
                <tr>
                    <td>{{ $plan->id }}</td>
                    <td>{{ $plan->title }}</td>
                    <td>{{ $plan->price }}</td>
                    <td>
                        <a href="{{ route('admin.plans.show', $plan) }}" class="btn btn-info">詳細</a>
                    </td>
                    <td>
                        <a href="{{ route('admin.plans.edit', $plan) }}" class="btn btn-warning">編集</a>
                    </td>
                    <td>
                        <form action="{{ route('admin.plans.destroy', $plan) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick='return confirm("本当に削除しますか？")'>削除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop
