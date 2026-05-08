@extends('layouts.admin')

@section('content')
@php
    $releaseRaw = $movie->release_date ?? null;
    $releaseValue = $releaseRaw instanceof \Carbon\CarbonInterface ? $releaseRaw->format('Y-m-d') : (string) $releaseRaw;
    $formTitleMap = ['Them phim' => 'Thêm phim', 'Sua phim' => 'Sửa phim'];
@endphp
<section class="admin-panel">
    <div class="admin-panel__head">
        <h2>{{ $formTitleMap[$title] ?? $title }}</h2>
        <a class="btn btn-default" href="{{ route('admin.movies.index') }}">Quay lại</a>
    </div>
    <div class="admin-panel__body">
        <form method="post" action="{{ $action }}">
            @csrf
            @if ($method !== 'POST') @method($method) @endif
            <div class="admin-form-grid">
                <div class="form-group full">
                    <label>Tên phim</label>
                    <input class="form-control" name="title" value="{{ old('title', $movie->title) }}" required>
                </div>
                <div class="form-group full">
                    <label>Mô tả</label>
                    <textarea class="form-control" name="description" rows="4">{{ old('description', $movie->description) }}</textarea>
                </div>
                <div class="form-group"><label>Thể loại</label><input class="form-control" name="genre" value="{{ old('genre', $movie->genre) }}"></div>
                <div class="form-group"><label>Thời lượng</label><input class="form-control" type="number" name="duration" value="{{ old('duration', $movie->duration) }}"></div>
                <div class="form-group"><label>Ngôn ngữ</label><input class="form-control" name="language" value="{{ old('language', $movie->language) }}"></div>
                <div class="form-group"><label>Ngày khởi chiếu</label><input class="form-control" type="date" name="release_date" value="{{ old('release_date', $releaseValue) }}"></div>
                <div class="form-group full"><label>URL poster</label><input class="form-control" name="poster" value="{{ old('poster', $movie->poster) }}"></div>
                <div class="form-group full"><label>URL trailer</label><input class="form-control" name="trailer" value="{{ old('trailer', $movie->trailer) }}"></div>
                <div class="form-group"><label>Độ tuổi</label><input class="form-control" name="age_label" value="{{ old('age_label', $movie->age_label) }}"></div>
                <div class="form-group">
                    <label>Nhóm phim</label>
                    <select class="form-control" name="section" required>
                        @foreach (['now-showing' => 'Đang chiếu', 'upcoming' => 'Sắp chiếu', 'special' => 'Suất đặc biệt'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('section', $movie->section ?? 'now-showing') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Hiển thị</label>
                    <select class="form-control" name="is_active" required>
                        <option value="1" @selected(old('is_active', (string) (int) ($movie->is_active ?? true)) === '1')>Hiển thị</option>
                        <option value="0" @selected(old('is_active', (string) (int) ($movie->is_active ?? true)) === '0')>Ẩn</option>
                    </select>
                </div>
            </div>
            <button class="btn btn-primary" type="submit">Lưu phim</button>
        </form>
    </div>
</section>
@endsection
