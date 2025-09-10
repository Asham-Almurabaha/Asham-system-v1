@extends('layouts.master')
@section('title', __('departments::departments.View Department'))
@section('content')
<div class="container py-3">
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="{{ route('departments.index') }}">@lang('departments::departments.Departments')</a></li>
      <li class="breadcrumb-item active" aria-current="page">@lang('departments::departments.View Department')</li>
    </ol>
  </nav>
  <div class="col-lg-8 mx-auto">
    <div class="card shadow-sm">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">@lang('departments::departments.View Department')</h5>
        <div class="d-flex gap-2">
          <x-btn href="{{ route('departments.edit', $item) }}" variant="primary" size="sm" icon="bi bi-pencil">@lang('departments::departments.Edit')</x-btn>
          <x-btn href="{{ route('departments.index') }}" variant="outline-secondary" size="sm" icon="bi bi-arrow-right-circle">@lang('setting.Back')</x-btn>
        </div>
      </div>
      <div class="card-body">
        <table class="table table-bordered">
            <tr><th style="width:220px">@lang('departments::departments.Name (EN)')</th><td class="fw-medium">{{ $item->name }}</td></tr>
            <tr><th>@lang('departments::departments.Name (AR)')</th><td class="fw-medium">{{ $item->name_ar }}</td></tr>
            <tr><th>@lang('departments::departments.Active')</th><td>{{ $item->is_active ? __('departments::departments.Active') : __('departments::departments.Inactive') }}</td></tr>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
