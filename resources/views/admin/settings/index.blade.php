@extends('layouts.admin')

@section('content')
<section class="admin-panel">
    <div class="admin-panel__head">
        <h2>Cấu hình vận hành</h2>
    </div>
    <div class="admin-panel__body">
        <form method="post" action="{{ route('admin.settings.update') }}" class="admin-form-grid">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Tên website</label>
                <input class="form-control" name="site_name" value="{{ old('site_name', $settings['site_name']) }}" required>
            </div>
            <div class="form-group">
                <label>Số hỗ trợ</label>
                <input class="form-control" name="support_phone" value="{{ old('support_phone', $settings['support_phone']) }}">
            </div>
            <div class="form-group">
                <label>Giá vé mặc định</label>
                <input class="form-control" type="number" name="default_ticket_price" value="{{ old('default_ticket_price', $settings['default_ticket_price']) }}" required>
            </div>
            <div class="form-group">
                <label>Thời gian giữ ghế (phút)</label>
                <input class="form-control" type="number" name="booking_hold_minutes" value="{{ old('booking_hold_minutes', $settings['booking_hold_minutes']) }}" required>
            </div>
            <div class="form-group full">
                <button class="btn btn-primary" type="submit">Lưu cấu hình</button>
            </div>
        </form>
    </div>
</section>

<section class="admin-panel">
    <div class="admin-panel__head">
        <h2>Ghi chú</h2>
    </div>
    <div class="admin-panel__body">
        <p class="admin-muted" style="margin:0;line-height:1.7;">
            Các cấu hình này được lưu vào collection MongoDB <strong>admin_settings</strong>.
            Đây là nền tảng để sau này nối tiếp vào giá vé mặc định, thông báo và quy tắc giữ ghế.
        </p>
    </div>
</section>
@endsection
