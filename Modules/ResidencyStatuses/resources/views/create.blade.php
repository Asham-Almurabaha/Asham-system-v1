@extends('layouts.master')
@section('title', __('residencystatuses.Create Residency Status'))
@section('content')
<div class="container py-3">
  <div class="col-lg-8 mx-auto">
    <div class="card shadow-sm">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">@lang('residencystatuses::residencystatuses.Create Residency Status')</h5>
        <x-btn href="{{ route('residency-statuses.index') }}" size="sm" variant="outline-secondary" icon="bi bi-arrow-right-circle">@lang('residencystatuses::residencystatuses.Back')</x-btn>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('residency-statuses.store') }}" class="row g-3">
          @csrf
          <div class="col-md-6">
            <label class="form-label">@lang('residencystatuses::residencystatuses.Name (EN)')</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">@lang('residencystatuses::residencystatuses.Name (AR)')</label>
            <input type="text" name="name_ar" class="form-control @error('name_ar') is-invalid @enderror" value="{{ old('name_ar') }}" required>
            @error('name_ar') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
          <div class="col-12 form-check">
            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">@lang('residencystatuses::residencystatuses.Active')</label>
          </div>
          <div class="col-12 d-flex gap-2">
            <x-btn variant="outline-success" type="submit" icon="bi bi-check2">@lang('users.Save')</x-btn>
            <x-btn href="{{ route('residency-statuses.index') }}" variant="outline-secondary">@lang('users.Cancel')</x-btn>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

