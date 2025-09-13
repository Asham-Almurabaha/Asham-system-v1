@extends('layouts.master')
@section('title', __('employees::residencystatuses.Residency Statuses'))
@section('content')
<div class="container py-3" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item active" aria-current="page">@lang('employees::residencystatuses.Residency Statuses')</li>
    </ol>
  </nav>

  <div class="d-flex align-items-center justify-content-between mb-3">
    <x-btn href="{{ route('residency-statuses.create') }}" size="sm" variant="success" icon="bi bi-plus-circle">@lang('employees::residencystatuses.Create Residency Status')</x-btn>
  </div>

  <div class="card shadow-sm">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>@lang('employees::residencystatuses.Name (EN)')</th>
            <th>@lang('employees::residencystatuses.Name (AR)')</th>
            <th>@lang('employees::residencystatuses.Active')</th>
            <th class="text-end">@lang('employees::residencystatuses.Actions')</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($items as $i)
            <tr>
              <td>{{ $i->id }}</td>
              <td>{{ $i->name_en }}</td>
              <td>{{ $i->name_ar }}</td>
              <td>
                @if($i->is_active)
                  <span class="badge bg-success-subtle text-success border">@lang('employees::residencystatuses.Active')</span>
                @else
                  <span class="badge bg-secondary-subtle text-secondary border">@lang('employees::residencystatuses.Inactive')</span>
                @endif
              </td>
              <td class="text-end">
                  <x-btn href="{{ route('residency-statuses.edit', $i) }}" size="sm" variant="outline-secondary" icon="bi bi-pencil">@lang('employees::residencystatuses.Edit')</x-btn>
                  <x-btn href="{{ route('residency-statuses.destroy', $i) }}" method="DELETE" size="sm" variant="outline-danger" icon="bi bi-trash" confirm="@lang('employees::residencystatuses.Delete confirm')">@lang('employees::residencystatuses.Delete')</x-btn>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center text-muted">@lang('employees::residencystatuses.No data')</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-body">{{ $items->links() }}</div>
  </div>
</div>
@endsection

