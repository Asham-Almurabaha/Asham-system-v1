@extends('layouts.master')
@section('title', __('org::branches.Branches'))
@section('content')
<div class="container py-3" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item active" aria-current="page">@lang('org::branches.Branches')</li>
    </ol>
  </nav>

  <div class="d-flex align-items-center justify-content-between mb-3">
    <x-btn href="{{ route('branches.create') }}" size="sm" variant="success" icon="bi bi-plus-circle">@lang('org::branches.Create Branch')</x-btn>
  </div>

  <div class="card shadow-sm">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>@lang('org::branches.Name (EN)')</th>
            <th>@lang('org::branches.Name (AR)')</th>
            <th>@lang('org::branches.Company')</th>
            <th>@lang('org::branches.Active')</th>
            <th class="text-end">@lang('org::branches.Actions')</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($items as $i)
            <tr>
              <td>{{ $i->id }}</td>
              <td>{{ $i->name_en }}</td>
              <td>{{ $i->name_ar }}</td>
              <td>{{ optional($i->company)->name_en }}</td>
              <td>
                @if($i->is_active)
                  <span class="badge bg-success-subtle text-success border">@lang('org::branches.Active')</span>
                @else
                  <span class="badge bg-secondary-subtle text-secondary border">@lang('org::branches.Inactive')</span>
                @endif
              </td>
              <td class="text-end">
                  <x-btn href="{{ route('branches.edit', $i) }}" size="sm" variant="outline-secondary" icon="bi bi-pencil">@lang('org::branches.Edit')</x-btn>
                  <x-btn href="{{ route('branches.destroy', $i) }}" method="DELETE" size="sm" variant="outline-danger" icon="bi bi-trash" confirm="@lang('org::branches.Delete confirm')">@lang('org::branches.Delete')</x-btn>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center text-muted">@lang('org::branches.No data')</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-body">{{ $items->links() }}</div>
  </div>
</div>
@endsection
