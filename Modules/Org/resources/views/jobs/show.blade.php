@extends('layouts.master')
@section('title', __('org::jobs.View Job'))
@section('content')
<div class="container py-3">
  <div class="col-lg-8 mx-auto">
    <div class="card shadow-sm">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">@lang('org::jobs.View Job')</h5>
        <x-btn href="{{ route('jobs.index') }}" size="sm" variant="outline-secondary" icon="bi bi-arrow-right-circle">@lang('org::jobs.Back')</x-btn>
      </div>
      <div class="card-body">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">@lang('org::jobs.Name (EN)')</label>
            <div class="form-control-plaintext">{{ $item->name_en }}</div>
          </div>
          <div class="col-md-6">
            <label class="form-label">@lang('org::jobs.Name (AR)')</label>
            <div class="form-control-plaintext">{{ $item->name_ar }}</div>
          </div>
          <div class="col-md-4">
            <label class="form-label">@lang('org::jobs.Company')</label>
            <div class="form-control-plaintext">{{ optional($item->company)->name_en }}</div>
          </div>
          <div class="col-md-4">
            <label class="form-label">@lang('org::jobs.Branch')</label>
            <div class="form-control-plaintext">{{ optional($item->branch)->name_en }}</div>
          </div>
          <div class="col-md-4">
            <label class="form-label">@lang('org::jobs.Department')</label>
            <div class="form-control-plaintext">{{ optional($item->department)->name_en }}</div>
          </div>
          <div class="col-md-6">
            <label class="form-label">@lang('org::jobs.Active')</label>
            <div class="form-control-plaintext">{{ $item->is_active ? __('org::jobs.Active') : __('org::jobs.Inactive') }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
