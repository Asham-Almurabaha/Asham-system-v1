@extends('layouts.master')
@section('title', __('org::workstatuses.Edit Work Status'))
@section('content')
<div class="container py-3">
  <div class="col-lg-8 mx-auto">
    <div class="card shadow-sm">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">@lang('org::workstatuses.Edit Work Status')</h5>
        <x-btn href="{{ route('work-statuses.index') }}" size="sm" variant="outline-secondary" icon="bi bi-arrow-right-circle">@lang('org::workstatuses.Back')</x-btn>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('work-statuses.update', $item) }}" class="row g-3">
          @csrf
          @method('PUT')
          <div class="col-md-6">
            <label class="form-label">@lang('org::workstatuses.Code')</label>
            <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code', $item->code) }}" required>
            @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">@lang('org::workstatuses.Name (EN)')</label>
            <input type="text" name="name_en" class="form-control @error('name_en') is-invalid @enderror" value="{{ old('name_en', $item->name_en) }}" required>
            @error('name_en') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">@lang('org::workstatuses.Name (AR)')</label>
            <input type="text" name="name_ar" class="form-control @error('name_ar') is-invalid @enderror" value="{{ old('name_ar', $item->name_ar) }}" required>
            @error('name_ar') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
          <div class="col-12 form-check">
            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" {{ old('is_active', $item->is_active) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">@lang('org::workstatuses.Active')</label>
          </div>
          <div class="col-12 d-flex gap-2">
            <x-btn variant="outline-success" type="submit" icon="bi bi-check2">@lang('users.Save')</x-btn>
            <x-btn href="{{ route('work-statuses.index') }}" variant="outline-secondary">@lang('users.Cancel')</x-btn>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

