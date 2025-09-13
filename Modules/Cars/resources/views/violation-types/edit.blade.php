@extends('layouts.master')
@section('title', __('cars::violation-types.Edit Violation Type'))
@section('content')
<div class="container py-3">
  <div class="col-lg-8 mx-auto">
    <div class="card shadow-sm">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">@lang('cars::violation-types.Edit Violation Type')</h5>
        <x-btn href="{{ route('violation-types.index') }}" size="sm" variant="outline-secondary" icon="bi bi-arrow-right-circle">@lang('cars::common.Back')</x-btn>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('violation-types.update', $item) }}" class="row g-3">
          @csrf
          @method('PUT')
          <div class="col-md-6">
            <label class="form-label">@lang('cars::violation-types.Name (EN)')</label>
            <input type="text" name="name_en" class="form-control @error('name_en') is-invalid @enderror" value="{{ old('name_en', $item->name_en) }}" required>
            @error('name_en')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">@lang('cars::violation-types.Name (AR)')</label>
            <input type="text" name="name_ar" class="form-control @error('name_ar') is-invalid @enderror" value="{{ old('name_ar', $item->name_ar) }}" required>
            @error('name_ar')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-12 d-flex gap-2">
            <x-btn variant="outline-success" type="submit" icon="bi bi-check2">@lang('cars::common.Save')</x-btn>
            <x-btn href="{{ route('violation-types.index') }}" variant="outline-secondary">@lang('cars::common.Cancel')</x-btn>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
