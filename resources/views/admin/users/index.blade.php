@extends('layouts.admin')

@section('content')
<section class="admin-panel">
    <div class="admin-panel__head"><h2>Người dùng</h2></div>
    <div class="admin-panel__body">
        <form method="get" class="admin-actions" style="margin-bottom:16px;">
            <input class="form-control" style="max-width:320px;" name="q" value="{{ $search }}" placeholder="Tìm theo email">
            <button class="btn btn-default" type="submit">Tìm</button>
        </form>
        @if ($users->isEmpty())
            <div class="admin-empty">Chưa có người dùng.</div>
        @else
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead><tr><th>Email</th><th>Tên</th><th>Điện thoại</th><th>Vai trò</th><th>Trạng thái</th><th></th></tr></thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <form method="post" action="{{ route('admin.users.update', ['user' => (string) $user->getKey()]) }}">
                                @csrf @method('PUT')
                                <td><strong>{{ $user->email }}</strong></td>
                                <td><input class="form-control" name="name" value="{{ $user->name }}" required></td>
                                <td><input class="form-control" name="phone" value="{{ $user->phone }}"></td>
                                <td>
                                    <select class="form-control" name="role">
                                        <option value="user" @selected(($user->role ?? 'user') === 'user')>Người dùng</option>
                                        <option value="admin" @selected(($user->role ?? 'user') === 'admin')>Quản trị viên</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control" name="status">
                                        <option value="1" @selected((bool) ($user->status ?? true))>Hoạt động</option>
                                        <option value="0" @selected(! (bool) ($user->status ?? true))>Đã khóa</option>
                                    </select>
                                </td>
                                <td class="admin-actions">
                                    <input class="form-control" style="max-width:160px;" type="password" name="password" placeholder="Mật khẩu mới">
                                    <button class="btn btn-default btn-sm" type="submit">Lưu</button>
                                </td>
                            </form>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{ $users->links() }}
        @endif
    </div>
</section>
@endsection
