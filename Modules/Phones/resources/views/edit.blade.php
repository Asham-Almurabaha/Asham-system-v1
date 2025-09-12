@extends('layouts.master')
@section('title', __('phones::phones.Edit Phone'))
@section('content')
<div class="container py-3" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="{{ route('phones.index') }}">@lang('phones::phones.Phones')</a></li>
      <li class="breadcrumb-item active" aria-current="page">@lang('phones::phones.Edit Phone')</li>
    </ol>
  </nav>
  <div class="col-lg-10 mx-auto">
    <div class="card shadow-sm">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">@lang('phones::phones.Edit Phone')</h5>
        <x-btn href="{{ route('phones.index') }}" size="sm" variant="outline-secondary" icon="bi bi-arrow-right-circle">@lang('phones::common.Back')</x-btn>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('phones.update', $phone) }}" class="row g-3">
          @csrf
          @method('PUT')
          @include('phones::_form')
          <div class="col-12 d-flex gap-2">
            <x-btn variant="outline-primary" type="submit" icon="bi bi-check2">@lang('phones::common.Save')</x-btn>
            <x-btn href="{{ route('phones.index') }}" variant="outline-secondary">@lang('phones::common.Cancel')</x-btn>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
