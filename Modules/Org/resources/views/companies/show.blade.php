@extends('layouts.master')
@section('title', __('org::companies.View Company'))
@section('content')
<div class="container py-3">
  <div class="col-lg-8 mx-auto">
    <div class="card shadow-sm">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">@lang('org::companies.View Company')</h5>
        <x-btn href="{{ route('companies.index') }}" size="sm" variant="outline-secondary" icon="bi bi-arrow-right-circle">@lang('org::companies.Back')</x-btn>
      </div>
      <div class="card-body">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">@lang('org::companies.Name (EN)')</label>
            <div class="form-control-plaintext">{{ $item->name_en }}</div>
          </div>
          <div class="col-md-6">
            <label class="form-label">@lang('org::companies.Name (AR)')</label>
            <div class="form-control-plaintext">{{ $item->name_ar }}</div>
          </div>
          <div class="col-md-4">
            <label class="form-label">@lang('org::companies.CR Number')</label>
            <div class="form-control-plaintext">{{ $item->cr_number }}</div>
          </div>
          <div class="col-md-4">
            <label class="form-label">@lang('org::companies.VAT Number')</label>
            <div class="form-control-plaintext">{{ $item->vat_number }}</div>
          </div>
          <div class="col-md-4">
            <label class="form-label">@lang('org::companies.IBAN')</label>
            <div class="form-control-plaintext">{{ $item->iban }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
