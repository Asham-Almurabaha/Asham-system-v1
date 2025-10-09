@extends('layouts.master')
@section('title', __('employees::employees.Employees'))
@section('content')
<div class="container py-3" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item active" aria-current="page">@lang('employees::employees.Employees')</li>
    </ol>
  </nav>

  <div class="d-flex align-items-center justify-content-between mb-3">
    <x-btn href="{{ route('employees.create') }}" size="sm" variant="success" icon="bi bi-plus-circle">
      @lang('employees::employees.Create Employee')
    </x-btn>
  </div>

  <div class="card shadow-sm">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>@lang('employees::employees.Worker Number')</th>
            <th>@lang('employees::employees.Name')</th>
            <th>@lang('employees::employees.Branch')</th>
            <th>@lang('employees::employees.Job')</th>
            <th>@lang('employees::employees.Active')</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($items as $i)
            <tr>
              <td>{{ $i->worker_number ?? '—' }}</td>
              <td>
                @php
                  $locale = app()->getLocale();
                  $first = $locale === 'ar' ? $i->first_name_ar : $i->first_name;
                  $last = $locale === 'ar' ? $i->last_name_ar : $i->last_name;
                  $fullName = trim(($first ?? '') . ' ' . ($last ?? ''));
                @endphp
                <a href="{{ route('employees.show', $i) }}"
                   class="fw-bold text-dark text-decoration-none hover-link">
                  {{ $fullName !== '' ? $fullName : __('employees::employees.Employee') }}
                </a>
              </td>
              <td>{{ $i->branch ? (app()->getLocale() === 'ar' ? $i->branch->name_ar : $i->branch->name_en) : '' }}</td>
              <td>{{ $i->job ? (app()->getLocale() === 'ar' ? $i->job->name_ar : $i->job->name_en) : '' }}</td>
              <td>
                @if($i->is_active)
                  <span class="badge bg-success-subtle text-success border">@lang('employees::employees.Active')</span>
                @else
                  <span class="badge bg-secondary-subtle text-secondary border">@lang('employees::employees.Inactive')</span>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center text-muted">@lang('employees::employees.No data')</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-body">{{ $items->links() }}</div>
  </div>
</div>
@endsection

@push('styles')
<style>
  .hover-link:hover {
    color: #0d6efd !important; /* Bootstrap primary blue */
  }
</style>
@endpush
