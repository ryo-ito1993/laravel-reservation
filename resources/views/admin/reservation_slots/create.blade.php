@extends('adminlte::page')

@section('title', '予約枠作成')

@section('content_header')
    <h1>予約枠作成</h1>
@stop

@section('content')
    <form action="{{ route('admin.reservation_slots.store') }}" method="post">
        @csrf
        @if ($errors->any())
            <div class="alert">
                <x-error-messages :$errors />
            </div>
        @endif

        <div class="mb-3">
            <label for="room_id" class="form-label">部屋タイプ:</label>
            <select name="room_id" id="room_id" class="form-select">
                <option disabled selected value>選択してください</option>
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>{{ $room->type }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="start_date" class="form-label">開始日:</label>
            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date') }}">
        </div>

        <div class="mb-3">
            <label for="end_date" class="form-label">終了日:</label>
            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date') }}">
        </div>

        <div class="mb-3">
            <label for="available_slots" class="form-label">予約枠数:</label>
            <select name="available_slots" id="available_slots" class="form-select">
            </select>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">料金:</label>
            <input type="number" name="price" id="price" class="form-control" value="{{ old('price') }}">
        </div>

        <button type="submit" class="btn btn-primary">送信</button>
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
                    const selected = i == "{{ old('available_slots') }}" ? 'selected' : '';
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
