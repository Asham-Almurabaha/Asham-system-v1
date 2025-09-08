@extends('layouts.master')
@section('title', __('branches.View Branch'))
@section('content')
<div class="container py-3">
  <div class="col-lg-8 mx-auto">
    <div class="card shadow-sm">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">@lang('branches::branches.View Branch')</h5>
        <x-btn href="{{ route('branches.index') }}" size="sm" variant="outline-secondary" icon="bi bi-arrow-right-circle">@lang('setting.Back')</x-btn>
      </div>
      <div class="card-body">
        <div class="row mb-3">
          <div class="col-md-6">
            <strong>@lang('branches::branches.Name (EN)'):</strong> {{ $item->name }}
          </div>
          <div class="col-md-6">
            <strong>@lang('branches::branches.Name (AR)'):</strong> {{ $item->name_ar }}
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-md-6">
            <strong>@lang('branches::branches.City'):</strong> {{ $item->city ? (app()->getLocale() === 'ar' ? $item->city->name_ar : $item->city->name) : '' }}
          </div>
          <div class="col-md-6">
            <strong>@lang('branches::branches.Active'):</strong>
            @if($item->is_active)
              <span class="badge bg-success-subtle text-success border">@lang('branches::branches.Active')</span>
            @else
              <span class="badge bg-secondary-subtle text-secondary border">@lang('branches::branches.Inactive')</span>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

