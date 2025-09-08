@extends('layouts.master')
@section('title', __('employees::employees.View Employee'))
@section('content')
<div class="container py-3">
  <div class="col-lg-8 mx-auto">
    <div class="card shadow-sm">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">@lang('employees::employees.View Employee')</h5>
        <x-btn href="{{ route('employees.index') }}" size="sm" variant="outline-secondary" icon="bi bi-arrow-right-circle">@lang('employees::employees.Back')</x-btn>
      </div>
      <div class="card-body">
        @if($item->photo_url)
        <div class="row mb-3">
          <div class="col-md-6">
            <strong>@lang('employees::employees.Photo'):</strong><br>
            <img src="{{ $item->photo_url }}" alt="@lang('employees::employees.Photo')" class="img-fluid rounded border" style="max-height:150px">
          </div>
        </div>
        @endif
        <div class="row mb-3">
          <div class="col-md-6"><strong>@lang('employees::employees.First Name (EN)'):</strong> {{ $item->first_name }}</div>
          <div class="col-md-6"><strong>@lang('employees::employees.First Name (AR)'):</strong> {{ $item->first_name_ar }}</div>
        </div>
        <div class="row mb-3">
          <div class="col-md-6"><strong>@lang('employees::employees.Last Name (EN)'):</strong> {{ $item->last_name }}</div>
          <div class="col-md-6"><strong>@lang('employees::employees.Last Name (AR)'):</strong> {{ $item->last_name_ar }}</div>
        </div>
        <div class="row mb-3">
          <div class="col-md-6"><strong>@lang('employees::employees.Email'):</strong> {{ $item->email }}</div>
          <div class="col-md-6"><strong>@lang('employees::employees.Phone Numbers'):</strong> {{ $item->phones->pluck('phone')->join(', ') }}</div>
        </div>
          <div class="row mb-3">
            <div class="col-md-6"><strong>@lang('employees::employees.Branch'):</strong> {{ $item->branch ? (app()->getLocale() === 'ar' ? $item->branch->name_ar : $item->branch->name) : '' }}</div>
            <div class="col-md-6"><strong>@lang('employees::employees.Department'):</strong> {{ $item->department ? (app()->getLocale() === 'ar' ? $item->department->name_ar : $item->department->name) : '' }}</div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6"><strong>@lang('employees::employees.Title'):</strong> {{ $item->title ? (app()->getLocale() === 'ar' ? $item->title->name_ar : $item->title->name) : '' }}</div>
            <div class="col-md-6"><strong>@lang('employees::employees.Nationality'):</strong> {{ $item->nationality ? (app()->getLocale() === 'ar' ? $item->nationality->name_ar : $item->nationality->name) : '' }}</div>
          </div>
        <div class="row mb-3">
          <div class="col-md-6"><strong>@lang('employees::employees.Hire Date'):</strong> {{ optional($item->hire_date)->format('Y-m-d') }}</div>
          <div class="col-md-6"><strong>@lang('employees::employees.Active'):</strong> {{ $item->is_active ? __('employees::employees.Active') : __('employees::employees.Inactive') }}</div>
        </div>

        <div class="d-flex align-items-center justify-content-between mb-2 mt-4">
          <h5 class="mb-0">@lang('employees::employees.Residencies')</h5>
          <x-btn href="{{ route('employees.residencies.create', $item) }}" size="sm" variant="outline-primary" icon="bi bi-plus-circle">@lang('employees::employees.Add Residency')</x-btn>
        </div>
        @if($item->residencies->isEmpty())
          <p>@lang('employees::employees.No data')</p>
        @else
          <table class="table table-striped">
            <thead>
              <tr>
                <th>@lang('employees::employees.Expiry Date')</th>
                <th>@lang('employees::employees.Employer Name')</th>
              </tr>
            </thead>
            <tbody>
              @foreach($item->residencies as $residency)
                <tr>
                  <td>{{ optional($residency->expiry_date)->format('Y-m-d') }}</td>
                  <td>{{ $residency->employer_name }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
