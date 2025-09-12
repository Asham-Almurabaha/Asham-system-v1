@extends('layouts.master')
@section('title', __('phones::phones.View Phone'))
@section('content')
<div class="container py-3" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
  <h2 class="mb-3">@lang('phones::phones.Phone'): {{ $phone->imei }}</h2>
  <div class="card mb-3">
    <div class="card-body">
      <p>@lang('phones::phones.Brand'): {{ $phone->brand }}</p>
      <p>@lang('phones::phones.Model'): {{ $phone->model }}</p>
      <p>@lang('phones::phones.Status'): {{ $phone->status->value }}</p>
    </div>
  </div>
  <div class="card">
    <div class="card-header">@lang('phones::assignments.Assignments')</div>
    <div class="card-body">
      @include('phones::assignments._form')
      @include('phones::assignments._list')
    </div>
  </div>
</div>
@endsection
