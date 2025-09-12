@extends('layouts.master')
@section('title', __('org::jobs.Jobs'))
@section('content')
<div class="container py-3" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item active" aria-current="page">@lang('org::jobs.Jobs')</li>
    </ol>
  </nav>

  <div class="d-flex align-items-center justify-content-between mb-3">
    <x-btn href="{{ route('jobs.create') }}" size="sm" variant="success" icon="bi bi-plus-circle">@lang('org::jobs.Create Job')</x-btn>
  </div>

  <div class="card shadow-sm">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>@lang('org::jobs.Name (EN)')</th>
            <th>@lang('org::jobs.Name (AR)')</th>
            <th>@lang('org::jobs.Company')</th>
            <th>@lang('org::jobs.Branch')</th>
            <th>@lang('org::jobs.Department')</th>
            <th>@lang('org::jobs.Active')</th>
            <th class="text-end">@lang('org::jobs.Actions')</th>
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
              <td>{{ optional($i->department)->name_en }}</td>
              <td>
                @if($i->is_active)
                  <span class="badge bg-success-subtle text-success border">@lang('org::jobs.Active')</span>
                @else
                  <span class="badge bg-secondary-subtle text-secondary border">@lang('org::jobs.Inactive')</span>
                @endif
              </td>
              <td class="text-end">
                  <x-btn href="{{ route('jobs.edit', $i) }}" size="sm" variant="outline-secondary" icon="bi bi-pencil">@lang('org::jobs.Edit')</x-btn>
                  <x-btn href="{{ route('jobs.destroy', $i) }}" method="DELETE" size="sm" variant="outline-danger" icon="bi bi-trash" confirm="@lang('org::jobs.Delete confirm')">@lang('org::jobs.Delete')</x-btn>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="text-center text-muted">@lang('org::jobs.No data')</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-body">{{ $items->links() }}</div>
  </div>
</div>
@endsection
