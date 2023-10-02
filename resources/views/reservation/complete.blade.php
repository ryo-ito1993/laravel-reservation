@extends('layouts.header')
@section('title', '予約完了')
@section('content')

<div class="mt-5 mx-5 p-4 border">
    <h3 class="d-flex  justify-content-center fw-bold">予約が完了いたしました！</h3>
    <p class="d-flex  justify-content-center">予約完了メールをお送りいたしましたので、ご確認ください。</p>
    <div class="offset-1 border border-1 p-3 d-flex col-10">
        <div class="me-3">
            <img src="{{ asset('storage/' . $plan->images[0]->image) }}" alt="Plan Image" class="img-fluid" style="height: 90px; width: 120px object-fit: cover; ">
        </div>
        <div  class="ml-3">
            <h6>予約日：{{ \Carbon\Carbon::parse($slot->date)->format('Y年m月d日') }}</h6>
            <h6>プラン：{{ $plan->title }}</h6>
            <h6>部屋タイプ：{{ $slot->room->type }}</h6>
            <h6>金額：￥{{ number_format($slot->price + $plan->price )}}</h6>
        </div>
    </div>
</div>

@endsection
