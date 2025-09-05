@extends('layouts.master')
@section('title', __('nationalities.Nationalities'))
@section('content')
<div class="container py-3" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('setting.Dashboard')</a></li>
      <li class="breadcrumb-item active" aria-current="page">@lang('nationalities.Nationalities')</li>
    </ol>
  </nav>

  <div class="d-flex align-items-center justify-content-between mb-3">
    <x-btn href="{{ route('nationalities.create') }}" size="sm" variant="success" icon="bi bi-plus-circle">@lang('nationalities.Create Nationality')</x-btn>
  </div>

  <div class="card shadow-sm">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>@lang('nationalities.Name (EN)')</th>
            <th>@lang('nationalities.Name (AR)')</th>
            <th>@lang('nationalities.Active')</th>
            <th class="text-end">@lang('nationalities.Actions')</th>
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
                  <span class="badge bg-success-subtle text-success border">@lang('nationalities.Active')</span>
                @else
                  <span class="badge bg-secondary-subtle text-secondary border">@lang('nationalities.Inactive')</span>
                @endif
              </td>
              <td class="text-end">
                <div class="d-inline-flex gap-1">
                  <x-btn href="{{ route('nationalities.edit', $i) }}" size="sm" variant="outline-secondary" icon="bi bi-pencil">@lang('nationalities.Edit')</x-btn>
                  <x-btn href="{{ route('nationalities.destroy', $i) }}" method="DELETE" size="sm" variant="outline-danger" icon="bi bi-trash" confirm="@lang('nationalities.Delete confirm')">@lang('nationalities.Delete')</x-btn>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center text-muted">@lang('nationalities.No data')</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-body">{{ $items->links() }}</div>
  </div>
</div>
@endsection

