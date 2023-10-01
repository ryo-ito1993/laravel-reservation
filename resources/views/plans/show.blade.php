@extends('layouts.header')
@section('title', '宿泊プラン詳細')

@section('content')
<div class="container mt-4">
    <h2>{{ $plan->title }}</h2>
    <p>{{ $plan->description }}</p>

    <div class="row mt-4">
        @foreach($plan->images as $image)
        <div class="col-md-4">
            <img src="{{ asset('storage/' . $image->image) }}" alt="Plan Image" class="img-fluid" style="height: 250px; object-fit: cover; ">
        </div>
        @endforeach
    </div>

    <div class="mt-4">
        <a href="{{ route('reservation.calender', ['plan' => $plan, 'room' => $room]) }}" class="btn btn-primary">空室確認へ</a>
    </div>
</div>
@endsection
