@extends('layouts.master')
@section('title', __('org::titles.Titles'))
@section('content')
<div class="container py-3" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item active" aria-current="page">@lang('org::titles.Titles')</li>
    </ol>
  </nav>

  <div class="d-flex align-items-center justify-content-between mb-3">
    <x-btn href="{{ route('titles.create') }}" size="sm" variant="success" icon="bi bi-plus-circle">@lang('org::titles.Create Title')</x-btn>
  </div>

  <div class="card shadow-sm">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>@lang('org::titles.Name (EN)')</th>
            <th>@lang('org::titles.Name (AR)')</th>
            <th>@lang('org::titles.Company')</th>
            <th>@lang('org::titles.Branch')</th>
            <th>@lang('org::titles.Department')</th>
            <th>@lang('org::titles.Active')</th>
            <th class="text-end">@lang('org::titles.Actions')</th>
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
                  <span class="badge bg-success-subtle text-success border">@lang('org::titles.Active')</span>
                @else
                  <span class="badge bg-secondary-subtle text-secondary border">@lang('org::titles.Inactive')</span>
                @endif
              </td>
              <td class="text-end">
                  <x-btn href="{{ route('titles.edit', $i) }}" size="sm" variant="outline-secondary" icon="bi bi-pencil">@lang('org::titles.Edit')</x-btn>
                  <x-btn href="{{ route('titles.destroy', $i) }}" method="DELETE" size="sm" variant="outline-danger" icon="bi bi-trash" confirm="@lang('org::titles.Delete confirm')">@lang('org::titles.Delete')</x-btn>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="text-center text-muted">@lang('org::titles.No data')</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-body">{{ $items->links() }}</div>
  </div>
</div>
@endsection
