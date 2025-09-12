@extends('layouts.master')
@section('title', __('motorcycles::motorcycles.View Motorcycle'))
@section('content')
<div class="container py-3" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
  <h2 class="mb-3">@lang('motorcycles::motorcycles.Motorcycle'): {{ $motorcycle->plate_number }}</h2>
  <div class="card mb-3">
    <div class="card-body">
      <p>@lang('motorcycles::motorcycles.Brand'): {{ $motorcycle->brand }}</p>
      <p>@lang('motorcycles::motorcycles.Model'): {{ $motorcycle->model }}</p>
      <p>@lang('motorcycles::motorcycles.Status'): {{ $motorcycle->status->value }}</p>
    </div>
  </div>
  <div class="card">
    <div class="card-header">@lang('motorcycles::assignments.Assignments')</div>
    <div class="card-body">
      @include('motorcycles::assignments._form')
      @include('motorcycles::assignments._list')
    </div>
  </div>
</div>
@endsection
