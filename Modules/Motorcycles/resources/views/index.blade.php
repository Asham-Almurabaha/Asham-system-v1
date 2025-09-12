@extends('layouts.master')
@section('title', __('motorcycles::motorcycles.Motorcycles'))
@section('content')
<div class="container py-3" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
  <div class="d-flex mb-3 justify-content-between">
    <h2>@lang('motorcycles::motorcycles.Motorcycles')</h2>
    <x-btn href="{{ route('motorcycles.create') }}" size="sm" variant="success" icon="bi bi-plus-circle">@lang('motorcycles::motorcycles.Create Motorcycle')</x-btn>
  </div>
  <div class="card shadow-sm">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>@lang('motorcycles::motorcycles.Plate Number')</th>
            <th>@lang('motorcycles::motorcycles.Status')</th>
            <th>@lang('motorcycles::motorcycles.Current Employee')</th>
            <th class="text-end">@lang('motorcycles::motorcycles.Actions')</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($motorcycles as $motorcycle)
            <tr>
              <td>{{ $motorcycle->id }}</td>
              <td>{{ $motorcycle->plate_number }}</td>
              <td>{{ $motorcycle->status->value }}</td>
              <td>{{ optional($motorcycle->currentAssignment?->employee)->first_name }}</td>
              <td class="text-end">
                <x-btn href="{{ route('motorcycles.show',$motorcycle) }}" size="sm" variant="outline-secondary" icon="bi bi-eye">@lang('motorcycles::motorcycles.View')</x-btn>
                <x-btn href="{{ route('motorcycles.edit',$motorcycle) }}" size="sm" variant="outline-primary" icon="bi bi-pencil"></x-btn>
              </td>
            </tr>
          @empty
            <tr><td colspan="5" class="text-center">@lang('motorcycles::motorcycles.No data')</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-body">{{ $motorcycles->links() }}</div>
  </div>
</div>
@endsection
