@extends('layouts.admin')

@section('content')
<section class="admin-panel">
    <div class="admin-panel__head"><h2>Thêm suất chiếu</h2></div>
    <div class="admin-panel__body">
        <form method="post" action="{{ route('admin.showtimes.store') }}" class="admin-form-grid">
            @csrf
            <div class="form-group">
                <label>Phim</label>
                <select class="form-control" name="movie_id" required>
                    <option value="">Chọn phim</option>
                    @foreach ($movies as $movie)
                        <option value="{{ (string) $movie->getKey() }}">{{ $movie->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Phòng</label>
                <select class="form-control" name="room_id" required>
                    <option value="">Chọn phòng</option>
                    @foreach ($rooms as $room)
                        @php $cinema = $cinemasById[(string) $room->cinema_id] ?? null; @endphp
                        <option value="{{ (string) $room->getKey() }}">{{ $cinema->name ?? 'Không có dữ liệu' }} - {{ $room->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group"><label>Bắt đầu</label><input class="form-control" type="datetime-local" name="start_time" required></div>
            <div class="form-group"><label>Kết thúc</label><input class="form-control" type="datetime-local" name="end_time" required></div>
            <div class="form-group"><label>Giá vé</label><input class="form-control" type="number" name="price" value="75000" required></div>
            <div class="form-group"><label>Định dạng</label><input class="form-control" name="format" value="2D Phụ đề" required></div>
            <div class="form-group full"><button class="btn btn-primary" type="submit">Thêm suất chiếu</button></div>
        </form>
    </div>
</section>

<section class="admin-panel">
    <div class="admin-panel__head"><h2>Danh sách suất chiếu</h2></div>
    <div class="admin-panel__body">
        @if ($showtimes->isEmpty())
            <div class="admin-empty">Chưa có suất chiếu.</div>
        @else
            <div class="table-responsive">
                <table class="table">
                    <thead><tr><th>Phim</th><th>Phòng</th><th>Bắt đầu</th><th>Giá</th><th>Thao tác</th></tr></thead>
                    <tbody>
                    @foreach ($showtimes as $showtime)
                        @php
                            $movie = $moviesById[(string) $showtime->movie_id] ?? null;
                            $room = $roomsById[(string) $showtime->room_id] ?? null;
                            $cinema = $room ? ($cinemasById[(string) $room->cinema_id] ?? null) : null;
                        @endphp
                        <tr>
                            <td>{{ $movie->title ?? 'Không có dữ liệu' }}</td>
                            <td>{{ $cinema->name ?? 'Không có dữ liệu' }} - {{ $room->name ?? '' }}</td>
                            <td>{{ optional($showtime->start_time)->format('d/m/Y H:i') }}</td>
                            <td>{{ number_format((int) $showtime->price) }}đ</td>
                            <td>
                                <form method="post" action="{{ route('admin.showtimes.update', ['showtime' => (string) $showtime->getKey()]) }}" class="admin-actions">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="movie_id" value="{{ (string) $showtime->movie_id }}">
                                    <input type="hidden" name="room_id" value="{{ (string) $showtime->room_id }}">
                                    <input class="form-control" style="max-width:190px;" type="datetime-local" name="start_time" value="{{ optional($showtime->start_time)->format('Y-m-d\TH:i') }}" required>
                                    <input class="form-control" style="max-width:190px;" type="datetime-local" name="end_time" value="{{ optional($showtime->end_time)->format('Y-m-d\TH:i') }}" required>
                                    <input class="form-control" style="max-width:100px;" type="number" name="price" value="{{ $showtime->price }}" required>
                                    <input class="form-control" style="max-width:130px;" name="format" value="{{ $showtime->format ?? '2D Phụ đề' }}" required>
                                    <button class="btn btn-sm" type="submit">Lưu</button>
                                </form>
                                <form method="post" action="{{ route('admin.showtimes.delete', ['showtime' => (string) $showtime->getKey()]) }}" class="admin-inline-form" onsubmit="return confirm('Xóa suất chiếu này?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="submit">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{ $showtimes->links() }}
        @endif
    </div>
</section>
@endsection
