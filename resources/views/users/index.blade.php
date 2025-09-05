@extends('layouts.master')

@section('title', __('users.Users'))

@section('content')
<div class="container py-3" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

  {{-- Breadcrumbs --}}
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('setting.Dashboard')</a></li>
      <li class="breadcrumb-item active" aria-current="page">@lang('users.Users')</li>
    </ol>
  </nav>

  <div class="d-flex align-items-center justify-content-between mb-3">
    <div>
      <h4 class="mb-0">@lang('users.Users')</h4>
      <small class="text-muted">@lang('users.Manage users and roles')</small>
    </div>
    <x-btn href="{{ route('users.create') }}" size="sm" variant="success" icon="bi bi-plus-circle">@lang('users.Add User')</x-btn>
  </div>

  <div class="card border-0 shadow-sm">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>@lang('users.Name')</th>
            <th>@lang('users.Email')</th>
            <th>@lang('users.Roles')</th>
            <th class="text-end">@lang('users.Actions')</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($users as $u)
            <tr>
              <td>{{ $u->id }}</td>
              <td>{{ $u->name }}</td>
              <td>{{ $u->email }}</td>
              <td>
                @forelse ($u->roles as $r)
                  <span class="badge text-bg-secondary me-1">{{ $r->name }}</span>
                @empty
                  <span class="text-muted">—</span>
                @endforelse
              </td>
              <td class="text-end">
                <div class="d-inline-flex gap-1">
                  <x-btn href="{{ route('users.edit', $u) }}" size="sm" variant="outline-secondary" icon="bi bi-person-gear">@lang('users.Edit User')</x-btn>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center text-muted">@lang('users.No users found.')</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="card-body">
      {{ $users->links() }}
    </div>
  </div>
</div>
@endsection
