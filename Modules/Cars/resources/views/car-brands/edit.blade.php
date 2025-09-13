@extends('layouts.master')
@section('title', __('cars::brands.Edit Car Brand'))
@section('content')
<div class="container py-3">
  <div class="col-lg-8 mx-auto">
    <div class="card shadow-sm">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">@lang('cars::brands.Edit Car Brand')</h5>
        <x-btn href="{{ route('car-brands.index') }}" size="sm" variant="outline-secondary" icon="bi bi-arrow-right-circle">@lang('cars::common.Back')</x-btn>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('car-brands.update', $item) }}" class="row g-3">
          @csrf
          @method('PUT')
          <div class="col-md-6">
            <label class="form-label">@lang('cars::brands.Type')</label>
            <select name="car_type_id" class="form-select @error('car_type_id') is-invalid @enderror" required>
              @foreach($types as $type)
                <option value="{{ $type->id }}" @selected(old('car_type_id', $item->car_type_id) == $type->id)>{{ app()->getLocale() === 'ar' ? $type->name_ar : $type->name_en }}</option>
              @endforeach
            </select>
            @error('car_type_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">@lang('cars::brands.Name (EN)')</label>
            <input type="text" name="name_en" class="form-control @error('name_en') is-invalid @enderror" value="{{ old('name_en', $item->name_en) }}" required>
            @error('name_en')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">@lang('cars::brands.Name (AR)')</label>
            <input type="text" name="name_ar" class="form-control @error('name_ar') is-invalid @enderror" value="{{ old('name_ar', $item->name_ar) }}" required>
            @error('name_ar')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-12 d-flex gap-2">
            <x-btn variant="outline-success" type="submit" icon="bi bi-check2">@lang('cars::common.Save')</x-btn>
            <x-btn href="{{ route('car-brands.index') }}" variant="outline-secondary">@lang('cars::common.Cancel')</x-btn>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
