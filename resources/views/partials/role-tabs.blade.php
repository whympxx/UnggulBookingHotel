@php $suffix = $mode === 'register' ? 'register' : 'login'; @endphp
<div class="role-tabs" role="tablist" aria-label="Jenis akun">
    <a href="{{ route($suffix) }}" class="{{ $role === 'user' ? 'active' : '' }}"><i class="fas fa-user"></i> Customer</a>
    <a href="{{ route('agent.'.$suffix) }}" class="{{ $role === 'agent' ? 'active' : '' }}"><i class="fas fa-user-tie"></i> Agent</a>
    @if ($mode === 'login' || filled(config('app.admin_registration_code')))
        <a href="{{ route('admin.'.$suffix) }}" class="{{ $role === 'admin' ? 'active' : '' }}"><i class="fas fa-user-shield"></i> Admin</a>
    @endif
</div>
