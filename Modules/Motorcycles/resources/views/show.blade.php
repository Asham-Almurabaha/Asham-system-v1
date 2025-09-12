@extends('layouts.master')
@section('title', __('motorcycles::motorcycles.View Motorcycle'))
@section('content')
<div class="container py-3" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="{{ route('motorcycles.index') }}">@lang('motorcycles::motorcycles.Motorcycles')</a></li>
      <li class="breadcrumb-item active" aria-current="page">@lang('motorcycles::motorcycles.View Motorcycle')</li>
    </ol>
  </nav>
  <div class="col-lg-10 mx-auto">
    <div class="card shadow-sm mb-3">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">@lang('motorcycles::motorcycles.View Motorcycle')</h5>
        <div class="d-flex gap-2">
          @can('motorcycles.update')
          <x-btn href="{{ route('motorcycles.edit', $motorcycle) }}" variant="primary" size="sm" icon="bi bi-pencil">@lang('motorcycles::common.Edit')</x-btn>
          @endcan
          <x-btn href="{{ route('motorcycles.index') }}" variant="outline-secondary" size="sm" icon="bi bi-arrow-right-circle">@lang('motorcycles::common.Back')</x-btn>
        </div>
      </div>
      <div class="card-body">
        <table class="table table-sm align-middle mb-0">
          <tbody>
            <tr><th style="width:220px">@lang('motorcycles::motorcycles.Plate Number')</th><td class="fw-medium">{{ $motorcycle->plate_number }}</td></tr>
            <tr><th>@lang('motorcycles::motorcycles.Chassis Number')</th><td class="fw-medium">{{ $motorcycle->chassis_number }}</td></tr>
            <tr><th>@lang('motorcycles::motorcycles.Brand')</th><td class="fw-medium">{{ $motorcycle->brand }}</td></tr>
            <tr><th>@lang('motorcycles::motorcycles.Model')</th><td class="fw-medium">{{ $motorcycle->model }}</td></tr>
            <tr><th>@lang('motorcycles::motorcycles.Year')</th><td class="fw-medium">{{ $motorcycle->year }}</td></tr>
            <tr><th>@lang('motorcycles::motorcycles.Color')</th><td class="fw-medium">{{ $motorcycle->color }}</td></tr>
            <tr><th>@lang('motorcycles::motorcycles.Status')</th><td>@lang('motorcycles::statuses.' . $motorcycle->status->value)</td></tr>
            <tr><th>@lang('motorcycles::motorcycles.Branch')</th><td>{{ $motorcycle->branch?->name }}</td></tr>
            <tr><th>@lang('motorcycles::motorcycles.Notes')</th><td>{{ $motorcycle->notes }}</td></tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="card shadow-sm">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">@lang('motorcycles::assignments.Assignments')</h5>
        <div class="d-flex gap-2">
          @if(!$motorcycle->currentAssignment)
            @can('motorcycles.assign')
              <x-btn data-bs-toggle="collapse" href="#assignForm" size="sm" variant="outline-success" icon="bi bi-box-arrow-in-right">@lang('motorcycles::assignments.Assign')</x-btn>
            @endcan
          @else
            @can('motorcycles.return')
              <x-btn data-bs-toggle="modal" data-bs-target="#returnModal" size="sm" variant="outline-warning" icon="bi bi-box-arrow-left">@lang('motorcycles::assignments.Return')</x-btn>
            @endcan
          @endif
        </div>
      </div>
      <div class="card-body">
        @if(!$motorcycle->currentAssignment)
          <div class="collapse show" id="assignForm">
            @include('motorcycles::assignments._form')
          </div>
        @endif
        @include('motorcycles::assignments._list')
      </div>
    </div>
  </div>
</div>
@include('motorcycles::assignments._return_modal')
@endsection
