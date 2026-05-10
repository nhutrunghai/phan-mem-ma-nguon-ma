@extends('layouts.admin')

@section('content')
<section class="admin-panel">
    <div class="admin-panel__head"><h2>Thêm phòng chiếu</h2></div>
    <div class="admin-panel__body">
        <form method="post" action="{{ route('admin.rooms.store') }}" class="admin-form-grid">
            @csrf
            <div class="form-group"><label>Tên phòng</label><input class="form-control" name="name" required></div>
            <div class="form-group"><label>Số ghế</label><input class="form-control" type="number" name="total_seats" min="1" max="300" required></div>
            <div class="form-group full"><button class="btn btn-primary" type="submit">Thêm phòng</button></div>
        </form>
    </div>
</section>

<section class="admin-panel">
    <div class="admin-panel__head"><h2>Danh sách phòng chiếu</h2></div>
    <div class="admin-panel__body">
        @if ($rooms->isEmpty())
            <div class="admin-empty">Chưa có phòng chiếu.</div>
        @else
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead><tr><th>Phòng</th><th>Số ghế</th><th>Thao tác</th></tr></thead>
                    <tbody>
                    @foreach ($rooms as $room)
                        <tr>
                            <td>
                                <form method="post" action="{{ route('admin.rooms.update', ['room' => (string) $room->getKey()]) }}" class="admin-actions">
                                    @csrf @method('PUT')
                                    <input class="form-control" style="max-width:220px;" name="name" value="{{ $room->name }}" required>
                                    <input class="form-control" style="max-width:110px;" type="number" name="total_seats" value="{{ $room->total_seats }}" min="1" max="300" required>
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
    </div>
</section>
@endsection
