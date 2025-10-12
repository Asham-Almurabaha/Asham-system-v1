@extends('layouts.master')
@section('title', __('employees::sponsorshipstatuses.Sponsorship Statuses'))
@section('content')
<div class="container py-3" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item active" aria-current="page">@lang('employees::sponsorshipstatuses.Sponsorship Statuses')</li>
    </ol>
  </nav>

  <div class="d-flex align-items-center justify-content-between mb-3">
    <x-btn href="{{ route('sponsorship-statuses.create') }}" size="sm" variant="success" icon="bi bi-plus-circle">@lang('employees::sponsorshipstatuses.Create Sponsorship Status')</x-btn>
  </div>

  <div class="card shadow-sm">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>@lang('employees::sponsorshipstatuses.Name (EN)')</th>
            <th>@lang('employees::sponsorshipstatuses.Name (AR)')</th>
            <th>@lang('employees::sponsorshipstatuses.Active')</th>
            <th class="text-end">@lang('employees::sponsorshipstatuses.Actions')</th>
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
                  <span class="badge bg-success-subtle text-success border">@lang('employees::sponsorshipstatuses.Active')</span>
                @else
                  <span class="badge bg-secondary-subtle text-secondary border">@lang('employees::sponsorshipstatuses.Inactive')</span>
                @endif
              </td>
              <td class="text-end">
                  <x-btn href="{{ route('sponsorship-statuses.edit', $i) }}" size="sm" variant="outline-secondary" icon="bi bi-pencil">@lang('employees::sponsorshipstatuses.Edit')</x-btn>
                  <x-btn href="{{ route('sponsorship-statuses.destroy', $i) }}" method="DELETE" size="sm" variant="outline-danger" icon="bi bi-trash" confirm="@lang('employees::sponsorshipstatuses.Delete confirm')">@lang('employees::sponsorshipstatuses.Delete')</x-btn>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center text-muted">@lang('employees::sponsorshipstatuses.No data')</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-body">{{ $items->links() }}</div>
  </div>
</div>
@endsection

