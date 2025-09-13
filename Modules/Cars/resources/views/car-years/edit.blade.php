@extends('layouts.master')
@section('title', __('cars::years.Edit Car Year'))
@section('content')
<div class="container py-3">
  <div class="col-lg-6 mx-auto">
    <div class="card shadow-sm">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">@lang('cars::years.Edit Car Year')</h5>
        <x-btn href="{{ route('car-years.index') }}" size="sm" variant="outline-secondary" icon="bi bi-arrow-right-circle">@lang('cars::common.Back')</x-btn>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('car-years.update', $item) }}" class="row g-3">
          @csrf
          @method('PUT')
          <div class="col-md-6">
            <label class="form-label">@lang('cars::years.Year')</label>
            <input type="number" name="year" class="form-control @error('year') is-invalid @enderror" value="{{ old('year', $item->year) }}" required>
            @error('year')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-12 d-flex gap-2">
            <x-btn variant="outline-success" type="submit" icon="bi bi-check2">@lang('cars::common.Save')</x-btn>
            <x-btn href="{{ route('car-years.index') }}" variant="outline-secondary">@lang('cars::common.Cancel')</x-btn>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
