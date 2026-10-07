@extends('layouts.dashboard')
@section('title', app()->getLocale() === 'ar' ? 'إدارة المستخدمين' : 'Manage Users')
@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:12px;">
    <div>
        <h2 style="font-family:'Playfair Display',serif;color:var(--navy);font-size:1.6rem;margin:0;">
            {{ app()->getLocale() === 'ar' ? 'المستخدمون' : 'Users' }}
        </h2>
        <p style="color:#666;margin:4px 0 0;font-size:.9rem;">{{ $users->total() }} {{ app()->getLocale() === 'ar' ? 'مستخدم' : 'user(s)' }}</p>
    </div>
    <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
        <form style="display:flex;gap:8px;">
            <input type="text" name="search" class="pk-input" style="width:160px;padding:8px 12px;"
                   placeholder="{{ app()->getLocale() === 'ar' ? 'بحث...' : 'Search...' }}" value="{{ request('search') }}">
            <select name="role" class="pk-input" style="width:auto;padding:8px 12px;">
                <option value="">{{ app()->getLocale() === 'ar' ? 'كل الأدوار' : 'All Roles' }}</option>
                <option value="admin"   {{ request('role') === 'admin'   ? 'selected' : '' }}>Admin</option>
                <option value="staff"   {{ request('role') === 'staff'   ? 'selected' : '' }}>Staff</option>
                <option value="visitor" {{ request('role') === 'visitor' ? 'selected' : '' }}>Visitor</option>
            </select>
            <button type="submit" class="btn-pk-sm"><i class="fas fa-search"></i></button>
        </form>
        <a href="{{ route('admin.users.create') }}" class="btn-pk-primary">
            <i class="fas fa-plus"></i>
            {{ app()->getLocale() === 'ar' ? 'إضافة مستخدم' : 'Add User' }}
        </a>
    </div>
</div>

<div class="dash-panel">
    <div class="table-responsive">
        <table class="pk-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'الاسم' : 'Name' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'البريد' : 'Email' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'الهاتف' : 'Phone' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'الدور' : 'Role' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'اللغة' : 'Lang' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'إجراءات' : 'Actions' }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td style="color:#999;font-size:.85rem;">{{ $user->id }}</td>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="width:34px;height:34px;border-radius:50%;background:{{ $user->role === 'admin' ? 'var(--navy)' : ($user->role === 'staff' ? 'var(--green)' : 'var(--gold)') }};display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:.85rem;flex-shrink:0;">
                                {{ mb_substr($user->name, 0, 1) }}
                            </div>
                            <span style="font-weight:600;color:var(--navy);">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td style="font-size:.85rem;color:#666;">{{ $user->email }}</td>
                    <td style="font-size:.85rem;color:#666;">{{ $user->phone ?? '—' }}</td>
                    <td>
                        @if($user->role === 'admin')
                            <span style="background:rgba(27,43,58,.12);color:var(--navy);font-size:.75rem;font-weight:700;padding:3px 10px;border-radius:12px;">ADMIN</span>
                        @elseif($user->role === 'staff')
                            <span style="background:rgba(45,106,79,.12);color:var(--green);font-size:.75rem;font-weight:700;padding:3px 10px;border-radius:12px;">STAFF</span>
                        @else
                            <span style="background:rgba(200,146,42,.12);color:#a06a00;font-size:.75rem;font-weight:700;padding:3px 10px;border-radius:12px;">VISITOR</span>
                        @endif
                    </td>
                    <td style="font-size:.8rem;color:#888;text-transform:uppercase;">{{ $user->language }}</td>
                    <td>
                        <div style="display:flex;gap:6px;">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-pk-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;"
                                  onsubmit="return confirm('{{ app()->getLocale() === 'ar' ? 'حذف هذا المستخدم؟' : 'Delete this user?' }}')">
                                @csrf @method('DELETE')
                                <button class="btn-pk-sm" style="background:#dc3545;border-color:#dc3545;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;padding:48px;color:#999;">
                        {{ app()->getLocale() === 'ar' ? 'لا يوجد مستخدمون' : 'No users found' }}
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div style="margin-top:16px;">{{ $users->links() }}</div>
    @endif
</div>

@endsection
