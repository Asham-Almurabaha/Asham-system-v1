@extends('layouts.master')
@section('title', __('cities.View City'))
@section('content')
<div class="container py-3">
  <div class="col-lg-8 mx-auto">
    <div class="card shadow-sm">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">@lang('cities::cities.View City')</h5>
        <x-btn href="{{ route('cities.index') }}" size="sm" variant="outline-secondary" icon="bi bi-arrow-right-circle">@lang('setting.Back')</x-btn>
      </div>
      <div class="card-body">
        <div class="row mb-3">
          <div class="col-md-6">
            <strong>@lang('cities::cities.Name (EN)'):</strong> {{ $item->name }}
          </div>
          <div class="col-md-6">
            <strong>@lang('cities::cities.Name (AR)'):</strong> {{ $item->name_ar }}
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <strong>@lang('cities::cities.Active'):</strong>
            @if($item->is_active)
              <span class="badge bg-success-subtle text-success border">@lang('cities::cities.Active')</span>
            @else
              <span class="badge bg-secondary-subtle text-secondary border">@lang('cities::cities.Inactive')</span>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

