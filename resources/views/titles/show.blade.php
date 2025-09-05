@extends('layouts.master')
@section('title', __('titles.View Title'))
@section('content')
<div class="container py-3">
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('setting.Dashboard')</a></li>
      <li class="breadcrumb-item"><a href="{{ route('titles.index') }}">@lang('titles.Job Titles')</a></li>
      <li class="breadcrumb-item active" aria-current="page">@lang('titles.View Title')</li>
    </ol>
  </nav>
  <div class="col-lg-8 mx-auto">
    <div class="card shadow-sm">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">@lang('titles.View Title')</h5>
        <div class="d-flex gap-2">
          <x-btn href="{{ route('titles.edit', $item) }}" variant="primary" size="sm" icon="bi bi-pencil">@lang('titles.Edit')</x-btn>
          <x-btn href="{{ route('titles.index') }}" variant="outline-secondary" size="sm" icon="bi bi-arrow-right-circle">@lang('setting.Back')</x-btn>
        </div>
      </div>
      <div class="card-body">
        <table class="table table-sm align-middle mb-0">
          <tbody>
            <tr><th style="width:220px">@lang('titles.Name (EN)')</th><td class="fw-medium">{{ $item->name }}</td></tr>
            <tr><th>@lang('titles.Name (AR)')</th><td class="fw-medium">{{ $item->name_ar }}</td></tr>
            <tr><th>@lang('titles.Active')</th><td>{{ $item->is_active ? __('titles.Active') : __('titles.Inactive') }}</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

