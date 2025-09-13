@extends('layouts.master')
@section('title', __('cars::models.Create Car Model'))
@section('content')
<div class="container py-3">
  <div class="col-lg-8 mx-auto">
    <div class="card shadow-sm">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">@lang('cars::models.Create Car Model')</h5>
        <x-btn href="{{ route('car-models.index') }}" size="sm" variant="outline-secondary" icon="bi bi-arrow-right-circle">@lang('cars::common.Back')</x-btn>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('car-models.store') }}" class="row g-3">
          @csrf
          <div class="col-md-6">
            <label class="form-label">@lang('cars::models.Type')</label>
            <select name="car_type_id" class="form-select @error('car_type_id') is-invalid @enderror" required>
              @foreach($types as $type)
                <option value="{{ $type->id }}" @selected(old('car_type_id') == $type->id)>{{ app()->getLocale() === 'ar' ? $type->name_ar : $type->name_en }}</option>
              @endforeach
            </select>
            @error('car_type_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">@lang('cars::models.Brand')</label>
            <select name="car_brand_id" class="form-select @error('car_brand_id') is-invalid @enderror" required>
              @foreach($brands as $brand)
                <option value="{{ $brand->id }}" @selected(old('car_brand_id') == $brand->id)>{{ app()->getLocale() === 'ar' ? $brand->name_ar : $brand->name_en }}</option>
              @endforeach
            </select>
            @error('car_brand_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">@lang('cars::models.Name (EN)')</label>
            <input type="text" name="name_en" class="form-control @error('name_en') is-invalid @enderror" value="{{ old('name_en') }}" required>
            @error('name_en')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">@lang('cars::models.Name (AR)')</label>
            <input type="text" name="name_ar" class="form-control @error('name_ar') is-invalid @enderror" value="{{ old('name_ar') }}" required>
            @error('name_ar')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-12 d-flex gap-2">
            <x-btn variant="outline-success" type="submit" icon="bi bi-check2">@lang('cars::common.Save')</x-btn>
            <x-btn href="{{ route('car-models.index') }}" variant="outline-secondary">@lang('cars::common.Cancel')</x-btn>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
