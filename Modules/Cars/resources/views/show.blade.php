@extends('layouts.master')
@section('title', __('cars::cars.View Car'))
@section('content')
<div class="container py-3" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="{{ route('cars.index') }}">@lang('cars::cars.Cars')</a></li>
      <li class="breadcrumb-item active" aria-current="page">@lang('cars::cars.View Car')</li>
    </ol>
  </nav>
  <div class="col-lg-10 mx-auto">
    <div class="card shadow-sm mb-3">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">@lang('cars::cars.View Car')</h5>
        <div class="d-flex gap-2">
          @can('cars.update')
          <x-btn href="{{ route('cars.edit', $car) }}" variant="primary" size="sm" icon="bi bi-pencil">@lang('cars::common.Edit')</x-btn>
          @endcan
          <x-btn href="{{ route('cars.index') }}" variant="outline-secondary" size="sm" icon="bi bi-arrow-right-circle">@lang('cars::common.Back')</x-btn>
        </div>
      </div>
      <div class="card-body">
        <table class="table table-sm align-middle mb-0">
          <tbody>
            <tr><th style="width:220px">@lang('cars::cars.Plate Number')</th><td class="fw-medium">{{ $car->plate_number }}</td></tr>
            <tr><th>@lang('cars::cars.VIN')</th><td class="fw-medium">{{ $car->vin }}</td></tr>
            <tr><th>@lang('cars::cars.Brand')</th><td class="fw-medium">{{ $car->brand?->{app()->getLocale() === 'ar' ? 'name_ar' : 'name_en'} }}</td></tr>
            <tr><th>@lang('cars::cars.Model')</th><td class="fw-medium">{{ $car->model?->{app()->getLocale() === 'ar' ? 'name_ar' : 'name_en'} }}</td></tr>
            <tr><th>@lang('cars::cars.Year')</th><td class="fw-medium">{{ $car->year?->year }}</td></tr>
            <tr><th>@lang('cars::cars.Color')</th><td class="fw-medium">{{ $car->color?->{app()->getLocale() === 'ar' ? 'name_ar' : 'name_en'} }}</td></tr>
            <tr><th>@lang('cars::cars.Status')</th><td>@lang('cars::statuses.' . $car->status?->name_en)</td></tr>
            <tr><th>@lang('cars::cars.Branch')</th><td>{{ $car->branch?->name }}</td></tr>
            <tr><th>@lang('cars::cars.Notes')</th><td>{{ $car->notes }}</td></tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="card shadow-sm">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">@lang('cars::assignments.Assignments')</h5>
        <div class="d-flex gap-2">
          @if(!$car->currentAssignment)
            @can('cars.assign')
              <x-btn data-bs-toggle="collapse" href="#assignForm" size="sm" variant="outline-success" icon="bi bi-box-arrow-in-right">@lang('cars::assignments.Assign')</x-btn>
            @endcan
          @else
            @can('cars.return')
              <x-btn data-bs-toggle="modal" data-bs-target="#returnModal" size="sm" variant="outline-warning" icon="bi bi-box-arrow-left">@lang('cars::assignments.Return')</x-btn>
            @endcan
          @endif
        </div>
      </div>
      <div class="card-body">
        @if(!$car->currentAssignment)
          <div class="collapse show" id="assignForm">
            @include('cars::assignments._form')
          </div>
        @endif
        @include('cars::assignments._list')
      </div>
    </div>
  </div>
</div>
@include('cars::assignments._return_modal')
@endsection
