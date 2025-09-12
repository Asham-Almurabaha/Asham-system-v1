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
    <x-btn href="{{ route(Route::has('hr.employees.create') ? 'hr.employees.create' : 'employees.create') }}" size="sm" variant="success" icon="bi bi-plus-circle">
      @lang('employees::employees.Create Employee')
    </x-btn>
  </div>

  <div class="card shadow-sm">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>
              @if(app()->getLocale() === 'ar')
                @lang('employees::employees.First Name (AR)')
              @else
                @lang('employees::employees.First Name (EN)')
              @endif
            </th>
            <th>
              @if(app()->getLocale() === 'ar')
                @lang('employees::employees.Last Name (AR)')
              @else
                @lang('employees::employees.Last Name (EN)')
              @endif
            </th>
            <th>@lang('employees::employees.Company')</th>
            <th>@lang('employees::employees.Branch')</th>
            <th>@lang('employees::employees.Job')</th>
            <th>@lang('employees::employees.Active')</th>
            <th class="text-end">@lang('employees::employees.Actions')</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($items as $i)
            <tr>
              <td>{{ $i->id }}</td>
              <td>
                <a href="{{ route(Route::has('hr.employees.show') ? 'hr.employees.show' : 'employees.show', $i) }}"
                   class="fw-bold text-dark text-decoration-none hover-link">
                  {{ app()->getLocale() === 'ar' ? $i->first_name_ar : $i->first_name }}
                </a>
              </td>
              <td>
                {{ app()->getLocale() === 'ar' ? $i->last_name_ar : $i->last_name }}
              </td>
              <td>{{ $i->company ? (app()->getLocale() === 'ar' ? $i->company->name_ar : $i->company->name_en) : '' }}</td>
              <td>{{ $i->branch ? (app()->getLocale() === 'ar' ? $i->branch->name_ar : $i->branch->name_en) : '' }}</td>
              <td>{{ $i->job ? (app()->getLocale() === 'ar' ? $i->job->name_ar : $i->job->name_en) : '' }}</td>
              <td>
                @if($i->is_active)
                  <span class="badge bg-success-subtle text-success border">@lang('employees::employees.Active')</span>
                @else
                  <span class="badge bg-secondary-subtle text-secondary border">@lang('employees::employees.Inactive')</span>
                @endif
              </td>
              <td class="text-end">
                <x-btn href="{{ route(Route::has('hr.employees.edit') ? 'hr.employees.edit' : 'employees.edit', $i) }}" size="sm" variant="outline-secondary" icon="bi bi-pencil">
                  @lang('employees::employees.Edit')
                </x-btn>
                <x-btn href="{{ route(Route::has('hr.employees.destroy') ? 'hr.employees.destroy' : 'employees.destroy', $i) }}" method="DELETE" size="sm" variant="outline-danger" icon="bi bi-trash" confirm="@lang('employees::employees.Delete confirm')">
                  @lang('employees::employees.Delete')
                </x-btn>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="text-center text-muted">@lang('employees::employees.No data')</td>
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
