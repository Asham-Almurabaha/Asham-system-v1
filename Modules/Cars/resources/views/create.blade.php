@extends('layouts.master')
@section('title', __('cars::cars.Create Car'))
@section('content')
<div class="container py-3" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="{{ route('cars.index') }}">@lang('cars::cars.Cars')</a></li>
      <li class="breadcrumb-item active" aria-current="page">@lang('cars::cars.Create Car')</li>
    </ol>
  </nav>
  <div class="col-lg-10 mx-auto">
    <div class="card shadow-sm">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">@lang('cars::cars.Create Car')</h5>
        <x-btn href="{{ route('cars.index') }}" size="sm" variant="outline-secondary" icon="bi bi-arrow-right-circle">@lang('cars::common.Back')</x-btn>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('cars.store') }}" class="row g-3">
          @csrf
          @include('cars::_form')
          <div class="col-12 d-flex gap-2">
            <x-btn variant="outline-success" type="submit" icon="bi bi-check2">@lang('cars::common.Save')</x-btn>
            <x-btn href="{{ route('cars.index') }}" variant="outline-secondary">@lang('cars::common.Cancel')</x-btn>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
