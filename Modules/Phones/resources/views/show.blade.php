@extends('layouts.master')
@section('title', __('phones::phones.View Phone'))
@section('content')
<div class="container py-3" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="{{ route('phones.index') }}">@lang('phones::phones.Phones')</a></li>
      <li class="breadcrumb-item active" aria-current="page">@lang('phones::phones.View Phone')</li>
    </ol>
  </nav>
  <div class="col-lg-10 mx-auto">
    <div class="card shadow-sm mb-3">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">@lang('phones::phones.View Phone')</h5>
        <div class="d-flex gap-2">
          @can('phones.update')
          <x-btn href="{{ route('phones.edit', $phone) }}" variant="primary" size="sm" icon="bi bi-pencil">@lang('phones::common.Edit')</x-btn>
          @endcan
          <x-btn href="{{ route('phones.index') }}" variant="outline-secondary" size="sm" icon="bi bi-arrow-right-circle">@lang('phones::common.Back')</x-btn>
        </div>
      </div>
      <div class="card-body">
        <table class="table table-sm align-middle mb-0">
          <tbody>
            <tr><th style="width:220px">@lang('phones::phones.IMEI')</th><td class="fw-medium">{{ $phone->imei }}</td></tr>
            <tr><th>@lang('phones::phones.Serial Number')</th><td class="fw-medium">{{ $phone->serial_number }}</td></tr>
            <tr><th>@lang('phones::phones.Brand')</th><td class="fw-medium">{{ $phone->brand }}</td></tr>
            <tr><th>@lang('phones::phones.Model')</th><td class="fw-medium">{{ $phone->model }}</td></tr>
            <tr><th>@lang('phones::phones.Color')</th><td class="fw-medium">{{ $phone->color }}</td></tr>
            <tr><th>@lang('phones::phones.Line Number')</th><td class="fw-medium">{{ $phone->line_number }}</td></tr>
            <tr><th>@lang('phones::phones.Status')</th><td>@lang('phones::statuses.' . $phone->status->value)</td></tr>
            <tr><th>@lang('phones::phones.Branch')</th><td>{{ $phone->branch?->name }}</td></tr>
            <tr><th>@lang('phones::phones.Notes')</th><td>{{ $phone->notes }}</td></tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="card shadow-sm">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">@lang('phones::assignments.Assignments')</h5>
        <div class="d-flex gap-2">
          @if(!$phone->currentAssignment)
            @can('phones.assign')
              <x-btn data-bs-toggle="collapse" href="#assignForm" size="sm" variant="outline-success" icon="bi bi-box-arrow-in-right">@lang('phones::assignments.Assign')</x-btn>
            @endcan
          @else
            @can('phones.return')
              <x-btn data-bs-toggle="modal" data-bs-target="#returnModal" size="sm" variant="outline-warning" icon="bi bi-box-arrow-left">@lang('phones::assignments.Return')</x-btn>
            @endcan
          @endif
        </div>
      </div>
      <div class="card-body">
        @if(!$phone->currentAssignment)
          <div class="collapse show" id="assignForm">
            @include('phones::assignments._form')
          </div>
        @endif
        @include('phones::assignments._list')
      </div>
    </div>
  </div>
</div>
@include('phones::assignments._return_modal')
@endsection
