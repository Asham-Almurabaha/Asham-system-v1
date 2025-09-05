@extends('layouts.master')

@section('title', __('profile.Profile'))

@section('content')
<div class="container py-3" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item active" aria-current="page">@lang('profile.Profile')</li>
    </ol>
  </nav>

  <div class="row g-3">
    <div class="col-lg-8">
      <div class="card shadow-sm">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h5 class="mb-0">@lang('profile.Profile Information')</h5>
        </div>
        <div class="card-body">
          <form method="POST" action="{{ route('profile.update') }}" class="row g-3">
            @csrf
            @method('PATCH')

            <div class="col-md-6">
              <label class="form-label">@lang('users.Name')</label>
              <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
              @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
              <label class="form-label">@lang('users.Email')</label>
              <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
              @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-12 d-flex gap-2">
              <x-btn variant="outline-primary" type="submit" icon="bi bi-check2">@lang('users.Save')</x-btn>
            </div>
          </form>
        </div>
      </div>

      <div class="card shadow-sm mt-3">
        <div class="card-header">
          <h5 class="mb-0">@lang('profile.Update Password')</h5>
        </div>
        <div class="card-body">
          <form method="POST" action="{{ route('password.update') }}" class="row g-3">
            @csrf
            @method('PUT')

            <div class="col-12">
              <label class="form-label">@lang('profile.Current Password')</label>
              <input type="password" name="current_password" class="form-control @if($errors->updatePassword?->has('current_password')) is-invalid @endif" autocomplete="current-password">
              @if($errors->updatePassword?->has('current_password'))
                <div class="invalid-feedback">{{ $errors->updatePassword->first('current_password') }}</div>
              @endif
            </div>

            <div class="col-md-6">
              <label class="form-label">@lang('users.Password')</label>
              <input type="password" name="password" class="form-control @if($errors->updatePassword?->has('password')) is-invalid @endif" autocomplete="new-password">
              @if($errors->updatePassword?->has('password'))
                <div class="invalid-feedback">{{ $errors->updatePassword->first('password') }}</div>
              @endif
            </div>

            <div class="col-md-6">
              <label class="form-label">@lang('users.Confirm Password')</label>
              <input type="password" name="password_confirmation" class="form-control" autocomplete="new-password">
            </div>

            <div class="col-12 d-flex gap-2">
              <x-btn variant="outline-primary" type="submit" icon="bi bi-check2">@lang('users.Save')</x-btn>
            </div>
          </form>
        </div>
      </div>

      <div class="card shadow-sm mt-3">
        <div class="card-header">
          <h6 class="mb-0 text-danger"><i class="bi bi-exclamation-triangle me-1"></i>@lang('setting.Danger Zone')</h6>
        </div>
        <div class="card-body">
          <p class="text-danger small mb-3">@lang('profile.Once your account is deleted, all data will be permanently removed.')</p>
          <form action="{{ route('profile.destroy') }}" method="POST" class="row g-2"
                onsubmit="return confirm('@lang('profile.Are you sure you want to delete your account?')')">
            @csrf
            @method('DELETE')
            <div class="col-md-6">
              <label class="form-label">@lang('profile.Current Password')</label>
              <input type="password" name="password" class="form-control @if($errors->userDeletion?->has('password')) is-invalid @endif" required>
              @if($errors->userDeletion?->has('password'))
                <div class="invalid-feedback">{{ $errors->userDeletion->first('password') }}</div>
              @endif
            </div>
            <div class="col-12">
              <x-btn variant="outline-danger" type="submit" icon="bi bi-trash">@lang('profile.Delete Account')</x-btn>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection
