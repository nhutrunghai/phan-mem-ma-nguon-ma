@extends('layouts.admin')

@section('content')
@php
    $sectionLabels = [
        'now-showing' => 'Đang chiếu',
        'upcoming' => 'Sắp chiếu',
        'special' => 'Suất đặc biệt',
    ];
@endphp
<section class="admin-panel">
    <div class="admin-panel__head">
        <h2>Danh sách phim</h2>
        <a class="btn btn-primary" href="{{ route('admin.movies.create') }}">Thêm phim</a>
    </div>
    <div class="admin-panel__body">
        <form method="get" class="admin-actions" style="margin-bottom:16px;">
            <input class="form-control" style="max-width:320px;" name="q" value="{{ $search }}" placeholder="Tìm theo tên phim">
            <button class="btn btn-default" type="submit">Tìm</button>
        </form>
        @if ($movies->isEmpty())
            <div class="admin-empty">Chưa có phim trong cơ sở dữ liệu.</div>
        @else
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead><tr><th>Tên phim</th><th>Thể loại</th><th>Thời lượng</th><th>Nhóm</th><th></th></tr></thead>
                    <tbody>
                    @foreach ($movies as $movie)
                        <tr>
                            <td><strong>{{ $movie->title }}</strong></td>
                            <td>{{ $movie->genre }}</td>
                            <td>{{ $movie->duration ? $movie->duration . ' phút' : '' }}</td>
                            <td><span class="admin-badge">{{ $sectionLabels[$movie->section] ?? $movie->section }}</span></td>
                            <td class="admin-actions">
                                <a class="btn btn-default btn-sm" href="{{ route('admin.movies.edit', ['movie' => (string) $movie->getKey()]) }}">Sửa</a>
                                <form class="admin-inline-form" method="post" action="{{ route('admin.movies.delete', ['movie' => (string) $movie->getKey()]) }}" onsubmit="return confirm('Xóa phim này?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="submit">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{ $movies->links() }}
        @endif
    </div>
</section>
@endsection
