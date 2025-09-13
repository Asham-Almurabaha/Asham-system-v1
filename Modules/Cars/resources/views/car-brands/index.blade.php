@extends('layouts.master')
@section('title', __('cars::brands.Car Brands'))
@section('content')
<div class="container py-3" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item active" aria-current="page">@lang('cars::brands.Car Brands')</li>
    </ol>
  </nav>

  <div class="d-flex align-items-center justify-content-between mb-3">
    <x-btn href="{{ route('car-brands.create') }}" size="sm" variant="success" icon="bi bi-plus-circle">@lang('cars::brands.Create Car Brand')</x-btn>
  </div>

  <div class="card shadow-sm">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>@lang('cars::brands.Type')</th>
            <th>@lang('cars::brands.Name (EN)')</th>
            <th>@lang('cars::brands.Name (AR)')</th>
            <th class="text-end">@lang('cars::cars.Actions')</th>
          </tr>
        </thead>
        <tbody>
          @forelse($items as $i)
            <tr>
              <td>{{ $i->id }}</td>
              <td>{{ app()->getLocale() === 'ar' ? $i->type->name_ar : $i->type->name_en }}</td>
              <td>{{ $i->name_en }}</td>
              <td>{{ $i->name_ar }}</td>
              <td class="text-end">
                <x-btn href="{{ route('car-brands.edit', $i) }}" size="sm" variant="outline-secondary" icon="bi bi-pencil">@lang('cars::common.Edit')</x-btn>
                <x-btn href="{{ route('car-brands.destroy', $i) }}" method="DELETE" size="sm" variant="outline-danger" icon="bi bi-trash" confirm="@lang('cars::common.Delete confirm')">@lang('cars::common.Delete')</x-btn>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center text-muted">@lang('cars::brands.No data')</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-body">{{ $items->links() }}</div>
  </div>
</div>
@endsection
