@extends('layouts.master')

@section('title', __('users.View User'))

@section('content')
<div class="container py-3" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

  {{-- Breadcrumbs --}}
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('setting.Dashboard')</a></li>
      <li class="breadcrumb-item"><a href="{{ route('users.index') }}">@lang('users.Users')</a></li>
      <li class="breadcrumb-item active" aria-current="page">@lang('users.View User')</li>
    </ol>
  </nav>

  <div class="col-lg-8 mx-auto">
    <div class="card shadow-sm">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">{{ $user->name }} <small class="text-muted"><{{ $user->email }}></small></h5>
        <div class="d-flex gap-2">
          <x-btn href="{{ route('users.edit', $user) }}" variant="primary" size="sm" icon="bi bi-pencil-square">@lang('setting.Edit')</x-btn>
          <x-btn href="{{ route('users.index') }}" variant="outline-secondary" size="sm" icon="bi bi-arrow-right-circle">@lang('users.Back to List')</x-btn>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-sm align-middle mb-0">
            <tbody>
              <tr>
                <th style="width:220px">@lang('users.Name')</th>
                <td class="fw-medium">{{ $user->name }}</td>
              </tr>
              <tr>
                <th>@lang('users.Email')</th>
                <td class="fw-medium">{{ $user->email }}</td>
              </tr>
              <tr>
                <th>@lang('users.Roles')</th>
                <td>
                  @forelse ($user->roles as $r)
                    <span class="badge text-bg-secondary me-1">{{ $r->name }}</span>
                  @empty
                    <span class="text-muted">-</span>
                  @endforelse
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection

