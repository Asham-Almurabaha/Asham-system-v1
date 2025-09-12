@extends('layouts.master')
@section('title', __('cars::cars.View Car'))
@section('content')
<div class="container py-3" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
  <h2 class="mb-3">@lang('cars::cars.Car'): {{ $car->plate_number }}</h2>
  <div class="card mb-3">
    <div class="card-body">
      <p>@lang('cars::cars.Brand'): {{ $car->brand }}</p>
      <p>@lang('cars::cars.Model'): {{ $car->model }}</p>
      <p>@lang('cars::cars.Status'): {{ $car->status->value }}</p>
    </div>
  </div>
  <div class="card">
    <div class="card-header">@lang('cars::assignments.Assignments')</div>
    <div class="card-body">
      @include('cars::assignments._form')
      @include('cars::assignments._list')
    </div>
  </div>
</div>
@endsection
