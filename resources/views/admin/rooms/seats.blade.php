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
        <h2>{{ $cinema->name ?? '' }} / {{ $room->name }}</h2>
        <a class="btn btn-default" href="{{ route('admin.cinemas.index') }}">Quay lại rạp</a>
    </div>
    <div class="admin-panel__body">
        @if ($seats->isEmpty())
            <div class="admin-empty">Phòng này chưa có ghế. Cập nhật số ghế ở trang rạp để tạo ghế tự động.</div>
        @else
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead><tr><th>Ghế</th><th>Loại ghế</th><th></th></tr></thead>
                    <tbody>
                    @foreach ($seats as $seat)
                        <tr>
                            <td><strong>{{ $seat->seat_number }}</strong></td>
                            <td>{{ $seatTypeLabels[$seat->seat_type] ?? $seat->seat_type }}</td>
                            <td>
                                <form method="post" action="{{ route('admin.seats.update', ['seat' => (string) $seat->getKey()]) }}" class="admin-actions">
                                    @csrf @method('PUT')
                                    <select class="form-control" style="max-width:180px;" name="seat_type">
                                        @foreach (['normal', 'vip', 'couple', 'blocked'] as $type)
                                            <option value="{{ $type }}" @selected($seat->seat_type === $type)>{{ $seatTypeLabels[$type] ?? $type }}</option>
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
