@extends('adminlte::page')

@section('title', '予約枠編集')

@section('content_header')
    <h1>予約枠編集</h1>
@stop

@section('content')
    <form action="{{ route('admin.reservation_slots.update', $reservation_slot) }}" method="post">
        @csrf
        @method('PUT')
        @if ($errors->any())
            <div class="alert">
                <x-error-messages :$errors />
            </div>
        @endif

        <div class="mb-3">
            <label for="room_id" class="form-label">部屋タイプ:</label>
            <select name="room_id" id="room_id" class="form-select">
                <option disabled value>選択してください</option>
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}" {{ old('room_id', $reservation_slot->room_id) == $room->id ? 'selected' : '' }}>{{ $room->type }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">日付:</label>
            <input type="date" name="date" id="date" class="form-control" value="{{ old('date', $reservation_slot->date) }}">
        </div>

        <div class="mb-3">
            <label for="available_slots" class="form-label">予約枠数:</label>
            <select name="available_slots" id="available_slots" class="form-select">
            </select>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">料金:</label>
            <input type="number" name="price" id="price" class="form-control" value="{{ old('price', $reservation_slot->price) }}">
        </div>

        <button type="submit" class="btn btn-primary">更新</button>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roomSelect = document.getElementById('room_id');
            const availableSlotsSelect = document.getElementById('available_slots');
            const rooms = @json($rooms);
            const selectedRoomId = roomSelect.value;

            if (selectedRoomId) {
                const selectedRoom = rooms.find(room => room.id == selectedRoomId);
                let options = '';

                for (let i = 1; i <= selectedRoom.room_count; i++) {
                    const selected = i == "{{ old('available_slots', $reservation_slot->available_slots) }}" ? 'selected' : '';
                    options += `<option value="${i}" ${selected}>${i}</option>`;
                }

                availableSlotsSelect.innerHTML = options;
            }

            roomSelect.addEventListener('change', function() {
                const roomId = this.value;
                const selectedRoom = rooms.find(room => room.id == roomId);
                let options = '';

                for (let i = 1; i <= selectedRoom.room_count; i++) {
                    options += `<option value="${i}">${i}</option>`;
                }

                availableSlotsSelect.innerHTML = options;
            });
        });
    </script>

@stop
