@extends('layouts.master')

@section('title', __('users.Edit User Roles'))

@section('content')
<div class="container py-3" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

  <div class="col-lg-8 mx-auto">
    <div class="card shadow-sm">
      <div class="card-header d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
          <i class="bi bi-people me-2"></i>
          <h5 class="mb-0">@lang('users.Edit Roles:') <span class="ms-2">{{ $user->name }} <small class="text-muted"><{{ $user->email }}></small></span></h5>
        </div>
        <x-btn href="{{ route('users.index') }}" variant="outline-secondary" size="sm" icon="bi bi-arrow-right-circle">@lang('users.Back to List')</x-btn>
      </div>

    <div class="card-body">
      {{-- @if ($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach ($errors->all() as $e)
              <li>{{ $e }}</li>
            @endforeach
          </ul>
        </div>
      @endif --}}

      <form method="POST" action="{{ route('users.roles.update', $user) }}" class="row g-3">
        @csrf
        @method('PUT')

        <div class="col-12">
          <label class="form-label">@lang('users.Available Roles')</label>
          <div class="row g-2">
            @foreach ($roles as $roleName => $label)
              <div class="col-12 col-md-4 mb-2">
                <div class="form-check">
                  <input class="form-check-input"
                         type="checkbox"
                         name="roles[]"
                         value="{{ $roleName }}"
                         id="role_{{ $roleName }}"
                         @checked(in_array($roleName, $current))>
                  <label class="form-check-label" for="role_{{ $roleName }}">
                    {{ $label }}
                  </label>
                </div>
              </div>
            @endforeach
          </div>
          <div class="form-text">@lang('users.Choose roles then save.')</div>
        </div>

        <div class="col-12 d-flex gap-2">
          <x-btn variant="outline-primary" type="submit" icon="bi bi-check2">@lang('users.Save')</x-btn>
          <x-btn href="{{ route('users.index') }}" variant="outline-secondary">@lang('users.Cancel')</x-btn>
        </div>
      </form>
    </div>
  </div>

</div>
@endsection
