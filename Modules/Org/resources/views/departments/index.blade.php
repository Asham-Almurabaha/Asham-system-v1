@extends('layouts.master')
@section('title', __('org::departments.Departments'))
@section('content')
<div class="container py-3" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item active" aria-current="page">@lang('org::departments.Departments')</li>
    </ol>
  </nav>

  <div class="d-flex align-items-center justify-content-between mb-3">
    <x-btn href="{{ route('departments.create') }}" size="sm" variant="success" icon="bi bi-plus-circle">@lang('org::departments.Create Department')</x-btn>
  </div>

  <div class="card shadow-sm">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>@lang('org::departments.Name (EN)')</th>
            <th>@lang('org::departments.Name (AR)')</th>
            <th>@lang('org::departments.Company')</th>
            <th>@lang('org::departments.Branch')</th>
            <th>@lang('org::departments.Active')</th>
            <th class="text-end">@lang('org::departments.Actions')</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($items as $i)
            <tr>
              <td>{{ $i->id }}</td>
              <td>{{ $i->name_en }}</td>
              <td>{{ $i->name_ar }}</td>
              <td>{{ optional($i->company)->name_en }}</td>
              <td>{{ optional($i->branch)->name_en }}</td>
              <td>
                @if($i->is_active)
                  <span class="badge bg-success-subtle text-success border">@lang('org::departments.Active')</span>
                @else
                  <span class="badge bg-secondary-subtle text-secondary border">@lang('org::departments.Inactive')</span>
                @endif
              </td>
              <td class="text-end">
                  <x-btn href="{{ route('departments.edit', $i) }}" size="sm" variant="outline-secondary" icon="bi bi-pencil">@lang('org::departments.Edit')</x-btn>
                  <x-btn href="{{ route('departments.destroy', $i) }}" method="DELETE" size="sm" variant="outline-danger" icon="bi bi-trash" confirm="@lang('org::departments.Delete confirm')">@lang('org::departments.Delete')</x-btn>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center text-muted">@lang('org::departments.No data')</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-body">{{ $items->links() }}</div>
  </div>
</div>
@endsection
