@extends('layouts.master')

@section('title', __('users.Edit User'))

@section('content')
<div class="container-xxl py-4" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

  <div class="mb-3">
    <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-secondary">
      @lang('users.Back to List')
    </a>
  </div>

  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
      <div class="d-flex align-items-center">
        <i class="bi bi-person-gear me-2"></i>
        <strong>@lang('users.Edit User')</strong>
        <span class="ms-2">{{ $user->name }} <small class="text-muted"><{{ $user->email }}></small></span>
      </div>
    </div>

    <div class="card-body">
      @if ($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach ($errors->all() as $e)
              <li>{{ $e }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="{{ route('users.update', $user) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
          <label class="form-label">@lang('users.Name')</label>
          <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
          <label class="form-label">@lang('users.Email')</label>
          <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-3">
          <label class="form-label">@lang('users.Password')</label>
          <input type="password" name="password" class="form-control">
          <div class="form-text">@lang('users.Leave password blank to keep current')</div>
        </div>

        <div class="mb-3">
          <label class="form-label">@lang('users.Confirm Password')</label>
          <input type="password" name="password_confirmation" class="form-control">
        </div>

        <div class="mb-3">
          <label class="form-label">@lang('users.Available Roles')</label>
          <div class="row">
            @foreach ($roles as $roleName => $label)
              <div class="col-12 col-md-4 mb-2">
                <div class="form-check">
                  <input class="form-check-input"
                         type="checkbox"
                         name="roles[]"
                         value="{{ $roleName }}"
                         id="role_{{ $roleName }}"
                         @checked(in_array($roleName, old('roles', $current ?? [])))>
                  <label class="form-check-label" for="role_{{ $roleName }}">
                    {{ $label }}
                  </label>
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <div class="d-flex gap-2">
          <button class="btn btn-primary">
            @lang('users.Save')
          </button>
          <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
            @lang('users.Cancel')
          </a>
        </div>
      </form>
    </div>
  </div>

</div>
@endsection
