@extends('layouts.master')
@section('title', __('org::companies.Companies'))
@section('content')
<div class="container py-3" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item active" aria-current="page">@lang('org::companies.Companies')</li>
    </ol>
  </nav>

  <div class="d-flex align-items-center justify-content-between mb-3">
    <x-btn href="{{ route('companies.create') }}" size="sm" variant="success" icon="bi bi-plus-circle">@lang('org::companies.Create Company')</x-btn>
  </div>

  <div class="card shadow-sm">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>@lang('org::companies.Name (EN)')</th>
            <th>@lang('org::companies.Name (AR)')</th>
            <th>@lang('org::companies.CR Number')</th>
            <th class="text-end">@lang('org::companies.Actions')</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($items as $i)
            <tr>
              <td>{{ $i->id }}</td>
              <td>{{ $i->name_en }}</td>
              <td>{{ $i->name_ar }}</td>
              <td>{{ $i->cr_number }}</td>
              <td class="text-end">
                  <x-btn href="{{ route('companies.edit', $i) }}" size="sm" variant="outline-secondary" icon="bi bi-pencil">@lang('org::companies.Edit')</x-btn>
                  <x-btn href="{{ route('companies.destroy', $i) }}" method="DELETE" size="sm" variant="outline-danger" icon="bi bi-trash" confirm="@lang('org::companies.Delete confirm')">@lang('org::companies.Delete')</x-btn>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center text-muted">@lang('org::companies.No data')</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-body">{{ $items->links() }}</div>
  </div>
</div>
@endsection
