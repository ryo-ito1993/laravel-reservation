@extends('adminlte::page')

@section('title', 'お問い合わせ詳細')

@section('content_header')
    <h1>お問い合わせ詳細</h1>
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
                        <p class="card-text">ID：{{ $contact->id }}</p>
                        <p class="card-text">タイトル：{{ $contact->name }}</p>
                        <p class="card-text">メールアドレス：{{ $contact->email }}</p>
                        <p>お問合せ内容：</p>
                        <p style="white-space: pre-wrap;">{{$contact->message}}</p>
                        <p class="card-text">対応状況：
                            <form action="{{ route('admin.contacts.updateStatus', $contact) }}" method="post">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()">
                                    <option value="0" @if($contact->status == 0) selected @endif>未対応</option>
                                    <option value="1" @if($contact->status == 1) selected @endif>対応中</option>
                                    <option value="2" @if($contact->status == 2) selected @endif>対応済</option>
                                </select>
                            </form>
                        </p>
                    </div>
                </div>
                <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary mt-3">戻る</a>
            </div>
        </div>
    </div>
@stop
