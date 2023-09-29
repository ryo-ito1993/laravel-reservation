@extends('adminlte::page')

@section('title', 'お問い合わせ一覧')

@section('content_header')
    <h1>お問い合わせ一覧</h1>
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
                <th>ステータス</th>
                <th>詳細</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contacts as $contact)
                <tr>
                    <td>{{ $contact->id }}</td>
                    <td>{{ $contact->name }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>
                        <form action="{{ route('admin.contacts.updateStatus', $contact) }}" method="post">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()">
                                <option value="0" @if($contact->status == 0) selected @endif>未対応</option>
                                <option value="1" @if($contact->status == 1) selected @endif>対応中</option>
                                <option value="2" @if($contact->status == 2) selected @endif>対応済</option>
                            </select>
                        </form>
                    </td>
                    <td>
                        <a href="{{ route('admin.contacts.show', $contact) }}" class="btn btn-primary">詳細</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop
