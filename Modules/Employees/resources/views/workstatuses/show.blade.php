@extends('layouts.master')
@section('title', __('employees::workstatuses.View Work Status'))
@section('content')
<div class="container py-3">
  <div class="col-lg-8 mx-auto">
    <div class="card shadow-sm">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">@lang('employees::workstatuses.View Work Status')</h5>
        <x-btn href="{{ route('work-statuses.index') }}" size="sm" variant="outline-secondary" icon="bi bi-arrow-right-circle">@lang('employees::workstatuses.Back')</x-btn>
      </div>
      <div class="card-body">
        <div class="row mb-3">
          <div class="col-md-6">
            <strong>@lang('employees::workstatuses.Name (EN)'):</strong> {{ $item->name_en }}
          </div>
          <div class="col-md-6">
            <strong>@lang('employees::workstatuses.Name (AR)'):</strong> {{ $item->name_ar }}
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <strong>@lang('employees::workstatuses.Active'):</strong>
            @if($item->is_active)
              <span class="badge bg-success-subtle text-success border">@lang('employees::workstatuses.Active')</span>
            @else
              <span class="badge bg-secondary-subtle text-secondary border">@lang('employees::workstatuses.Inactive')</span>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

