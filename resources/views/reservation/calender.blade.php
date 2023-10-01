@extends('layouts.header')
@section('title', '予約カレンダー')

@section('content')

<div class="container">
    <h2 class="mt-4 mb-4">空室カレンダー</h2>
    <div class="row offset-1">
        <div class="border border-1 bg-white m-3 p-3 d-flex col-10">
            <div class="me-3">
                <img src="{{ asset('storage/' . $plan->images[0]->image) }}" alt="Plan Image" class="img-fluid" style="height: 90px; width: 120px object-fit: cover; ">
            </div>
            <div  class="ml-3">
                <h5>{{ $plan->title }}</h5>
                <div>{{ Str::limit($plan->description, 100) }}</div>
                <div class="mt-1">
                    <a href="{{ route('plans.show', $plan) }}">プラン詳細</a>
                </div>
            </div>
        </div>
        <div class="col-10 offset-1 mb-3">
            <h5>ご希望のお部屋を選択してください。</h5>
        </div>
        <div class="row offset-1">
            @foreach($rooms as $each_room)
                <div class="mr-2 mb-4 {{ $room->id == $each_room->id ? 'border border-primary shadow' : '' }}">
                    <a href="{{ route('reservation.calender', ['plan' => $plan, 'room' => $each_room]) }}">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $each_room->type }}</h5>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    <div style="width: 70%;margin: auto">
        <div id='calendar'></div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var selectedPlanId = "{{ $plan->id }}";
        var selectedRoomId = "{{ $room->id }}";
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: '/calenders/' + selectedPlanId + '/' + selectedRoomId,
            eventContent: function(arg) {
                let title = arg.event.title.split('|');
                let content = '<div>';
                for (let i = 0; i < title.length; i++) {
                    if (title[i] !== "") {
                        content += `<div>${title[i]}</div>`;
                    } else {
                        content += '<div></div>'; // 空のdivを追加して改行を実現
                    }
                }
                content += '</div>';
                return { html: content };
            }
        });
        calendar.render();
    });
</script>

@endsection
