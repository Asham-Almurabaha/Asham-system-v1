@extends('layouts.master')
@section('title', __('org::departments.View Department'))
@section('content')
<div class="container py-3">
  <div class="col-lg-8 mx-auto">
    <div class="card shadow-sm">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">@lang('org::departments.View Department')</h5>
        <x-btn href="{{ route('departments.index') }}" size="sm" variant="outline-secondary" icon="bi bi-arrow-right-circle">@lang('org::departments.Back')</x-btn>
      </div>
      <div class="card-body">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">@lang('org::departments.Name (EN)')</label>
            <div class="form-control-plaintext">{{ $item->name_en }}</div>
          </div>
          <div class="col-md-6">
            <label class="form-label">@lang('org::departments.Name (AR)')</label>
            <div class="form-control-plaintext">{{ $item->name_ar }}</div>
          </div>
          <div class="col-md-6">
            <label class="form-label">@lang('org::departments.Active')</label>
            <div class="form-control-plaintext">{{ $item->is_active ? __('org::departments.Active') : __('org::departments.Inactive') }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
