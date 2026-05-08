@extends('layouts.admin')

@section('content')
<section class="admin-panel">
    <div class="admin-panel__head"><h2>Thêm rạp</h2></div>
    <div class="admin-panel__body">
        <form method="post" action="{{ route('admin.cinemas.store') }}" class="admin-form-grid">
            @csrf
            <div class="form-group"><label>Tên rạp</label><input class="form-control" name="name" required></div>
            <div class="form-group"><label>Thành phố</label><input class="form-control" name="city" required></div>
            <div class="form-group full"><label>Địa chỉ</label><input class="form-control" name="address" required></div>
            <div class="form-group full"><button class="btn btn-primary" type="submit">Thêm rạp</button></div>
        </form>
    </div>
</section>

@foreach ($cinemas as $cinema)
    <section class="admin-panel">
        <div class="admin-panel__head">
            <h2>{{ $cinema->name }}</h2>
            <form method="post" action="{{ route('admin.cinemas.delete', ['cinema' => (string) $cinema->getKey()]) }}" onsubmit="return confirm('Xóa rạp này?')">
                @csrf @method('DELETE')
                <button class="btn btn-danger btn-sm" type="submit">Xóa rạp</button>
            </form>
        </div>
        <div class="admin-panel__body">
            <form method="post" action="{{ route('admin.cinemas.update', ['cinema' => (string) $cinema->getKey()]) }}" class="admin-form-grid">
                @csrf @method('PUT')
                <div class="form-group"><label>Tên rạp</label><input class="form-control" name="name" value="{{ $cinema->name }}" required></div>
                <div class="form-group"><label>Thành phố</label><input class="form-control" name="city" value="{{ $cinema->city }}" required></div>
                <div class="form-group full"><label>Địa chỉ</label><input class="form-control" name="address" value="{{ $cinema->address }}" required></div>
                <div class="form-group full"><button class="btn btn-default" type="submit">Cập nhật rạp</button></div>
            </form>

            <h3 style="margin-top:12px;">Phòng chiếu</h3>
            @php $rooms = $roomsByCinema[(string) $cinema->getKey()] ?? collect(); @endphp
            @if ($rooms->isEmpty())
                <div class="admin-empty">Rạp này chưa có phòng chiếu.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead><tr><th>Phòng</th><th>Số ghế</th><th></th></tr></thead>
                        <tbody>
                        @foreach ($rooms as $room)
                            <tr>
                                <td>
                                    <form method="post" action="{{ route('admin.rooms.update', ['room' => (string) $room->getKey()]) }}" class="admin-actions">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="cinema_id" value="{{ (string) $cinema->getKey() }}">
                                        <input class="form-control" style="max-width:180px;" name="name" value="{{ $room->name }}" required>
                                        <input class="form-control" style="max-width:100px;" type="number" name="total_seats" value="{{ $room->total_seats }}" required>
                                        <button class="btn btn-default btn-sm" type="submit">Lưu</button>
                                    </form>
                                </td>
                                <td>{{ $room->total_seats }}</td>
                                <td class="admin-actions">
                                    <a class="btn btn-default btn-sm" href="{{ route('admin.rooms.seats', ['room' => (string) $room->getKey()]) }}">Ghế</a>
                                    <form class="admin-inline-form" method="post" action="{{ route('admin.rooms.delete', ['room' => (string) $room->getKey()]) }}" onsubmit="return confirm('Xóa phòng này?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm" type="submit">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <form method="post" action="{{ route('admin.rooms.store') }}" class="admin-actions" style="margin-top:12px;">
                @csrf
                <input type="hidden" name="cinema_id" value="{{ (string) $cinema->getKey() }}">
                <input class="form-control" style="max-width:220px;" name="name" placeholder="Tên phòng" required>
                <input class="form-control" style="max-width:120px;" type="number" name="total_seats" placeholder="Số ghế" required>
                <button class="btn btn-primary" type="submit">Thêm phòng</button>
            </form>
        </div>
    </section>
@endforeach

@if ($cinemas->isEmpty())
    <section class="admin-panel"><div class="admin-empty">Chưa có rạp.</div></section>
@endif
@endsection
