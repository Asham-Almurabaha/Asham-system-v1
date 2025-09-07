@extends('layouts.master')
@section('title', __('branches.Edit Branch'))
@section('content')
<div class="container py-3">
  <div class="col-lg-8 mx-auto">
    <div class="card shadow-sm">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">@lang('branches.Edit Branch')</h5>
        <x-btn href="{{ route('branches.index') }}" size="sm" variant="outline-secondary" icon="bi bi-arrow-right-circle">@lang('setting.Back')</x-btn>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('branches.update', $item) }}" class="row g-3">
          @csrf
          @method('PUT')
          <div class="col-md-6">
            <label class="form-label">@lang('branches.Name (EN)')</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $item->name) }}" required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">@lang('branches.Name (AR)')</label>
            <input type="text" name="name_ar" class="form-control @error('name_ar') is-invalid @enderror" value="{{ old('name_ar', $item->name_ar) }}" required>
            @error('name_ar') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">@lang('branches.City')</label>
            <select name="city_id" class="form-select @error('city_id') is-invalid @enderror" required>
              @foreach($cities as $c)
                <option value="{{ $c->id }}" {{ old('city_id', $item->city_id) == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
              @endforeach
            </select>
            @error('city_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
          <div class="col-12 form-check">
            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" {{ old('is_active', $item->is_active) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">@lang('branches.Active')</label>
          </div>
          <div class="col-12 d-flex gap-2">
            <x-btn variant="outline-success" type="submit" icon="bi bi-check2">@lang('users.Save')</x-btn>
            <x-btn href="{{ route('branches.index') }}" variant="outline-secondary">@lang('users.Cancel')</x-btn>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

