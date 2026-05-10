@extends('layouts.admin')

@section('content')
@php
    $seatTypeLabels = [
        'normal' => 'Thường',
        'vip' => 'VIP',
        'couple' => 'Đôi',
        'blocked' => 'Khóa',
    ];
@endphp
<section class="admin-panel">
    <div class="admin-panel__head">
        <h2>{{ $room->name }}</h2>
        <a class="btn btn-default" href="{{ route('admin.rooms.index') }}">Quay lại phòng chiếu</a>
    </div>
    <div class="admin-panel__body">
        @if ($seats->isEmpty())
            <div class="admin-empty">Phòng này chưa có ghế. Cập nhật số ghế ở trang phòng chiếu để tạo ghế tự động.</div>
        @else
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead><tr><th>Ghế</th><th>Loại ghế</th><th>Thao tác</th></tr></thead>
                    <tbody>
                    @foreach ($seats as $seat)
                        <tr>
                            <td>{{ $seat->seat_number }}</td>
                            <td>{{ $seatTypeLabels[$seat->seat_type] ?? $seat->seat_type }}</td>
                            <td>
                                <form method="post" action="{{ route('admin.seats.update', ['seat' => (string) $seat->getKey()]) }}" class="admin-actions">
                                    @csrf @method('PUT')
                                    <select class="form-control" style="max-width:160px;" name="seat_type">
                                        @foreach ($seatTypeLabels as $value => $label)
                                            <option value="{{ $value }}" @selected($seat->seat_type === $value)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-default btn-sm" type="submit">Lưu</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</section>
@endsection
