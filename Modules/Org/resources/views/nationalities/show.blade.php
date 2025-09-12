@extends('layouts.master')
@section('title', __('org::nationalities.View Nationality'))
@section('content')
<div class="container py-3">
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('setting.Dashboard')</a></li>
      <li class="breadcrumb-item"><a href="{{ route('nationalities.index') }}">@lang('org::nationalities.Nationalities')</a></li>
      <li class="breadcrumb-item active" aria-current="page">@lang('org::nationalities.View Nationality')</li>
    </ol>
  </nav>
  <div class="col-lg-8 mx-auto">
    <div class="card shadow-sm">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">@lang('org::nationalities.View Nationality')</h5>
        <div class="d-flex gap-2">
          <x-btn href="{{ route('nationalities.edit', $item) }}" variant="primary" size="sm" icon="bi bi-pencil">@lang('org::nationalities.Edit')</x-btn>
          <x-btn href="{{ route('nationalities.index') }}" variant="outline-secondary" size="sm" icon="bi bi-arrow-right-circle">@lang('setting.Back')</x-btn>
        </div>
      </div>
      <div class="card-body">
        <table class="table table-sm align-middle mb-0">
          <tbody>
            <tr><th style="width:220px">@lang('org::nationalities.Name (EN)')</th><td class="fw-medium">{{ $item->name_en }}</td></tr>
            <tr><th>@lang('org::nationalities.Name (AR)')</th><td class="fw-medium">{{ $item->name_ar }}</td></tr>
            <tr><th>@lang('org::nationalities.Active')</th><td>{{ $item->is_active ? __('org::nationalities.Active') : __('org::nationalities.Inactive') }}</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

