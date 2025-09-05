@extends('layouts.master')
@section('title', __('titles.Job Titles'))
@section('content')
<div class="container py-3">
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item active" aria-current="page">@lang('titles.Job Titles')</li>
    </ol>
  </nav>

  <div class="d-flex align-items-center justify-content-between mb-3">
    <x-btn href="{{ route('titles.create') }}" size="sm" variant="success" icon="bi bi-plus-circle">@lang('titles.Create Title')</x-btn>
  </div>

  <div class="card shadow-sm">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>@lang('titles.Name (EN)')</th>
            <th>@lang('titles.Name (AR)')</th>
            <th>@lang('titles.Active')</th>
            <th class="text-end">@lang('titles.Actions')</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($items as $i)
            <tr>
              <td>{{ $i->id }}</td>
              <td>{{ $i->name }}</td>
              <td>{{ $i->name_ar }}</td>
              <td>
                @if($i->is_active)
                  <span class="badge bg-success-subtle text-success border">@lang('titles.Active')</span>
                @else
                  <span class="badge bg-secondary-subtle text-secondary border">@lang('titles.Inactive')</span>
                @endif
              </td>
              <td class="text-end">
                <div class="d-inline-flex gap-1">
                  <x-btn href="{{ route('titles.edit', $i) }}" size="sm" variant="outline-secondary" icon="bi bi-pencil">@lang('titles.Edit')</x-btn>
                  <x-btn href="{{ route('titles.destroy', $i) }}" method="DELETE" size="sm" variant="outline-danger" icon="bi bi-trash" confirm="@lang('titles.Delete confirm')">@lang('titles.Delete')</x-btn>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center text-muted">@lang('titles.No data')</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-body">{{ $items->links() }}</div>
  </div>
</div>
@endsection

