@extends('layouts.master')
@section('title', __('motorcycles::motorcycles.Edit Motorcycle'))
@section('content')
<div class="container py-3" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="{{ route('motorcycles.index') }}">@lang('motorcycles::motorcycles.Motorcycles')</a></li>
      <li class="breadcrumb-item active" aria-current="page">@lang('motorcycles::motorcycles.Edit Motorcycle')</li>
    </ol>
  </nav>
  <div class="col-lg-10 mx-auto">
    <div class="card shadow-sm">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">@lang('motorcycles::motorcycles.Edit Motorcycle')</h5>
        <x-btn href="{{ route('motorcycles.index') }}" size="sm" variant="outline-secondary" icon="bi bi-arrow-right-circle">@lang('motorcycles::common.Back')</x-btn>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('motorcycles.update', $motorcycle) }}" class="row g-3">
          @csrf
          @method('PUT')
          @include('motorcycles::_form')
          <div class="col-12 d-flex gap-2">
            <x-btn variant="outline-primary" type="submit" icon="bi bi-check2">@lang('motorcycles::common.Save')</x-btn>
            <x-btn href="{{ route('motorcycles.index') }}" variant="outline-secondary">@lang('motorcycles::common.Cancel')</x-btn>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
