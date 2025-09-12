@extends('layouts.master')
@section('title', __('cars::cars.Cars'))
@section('content')
<div class="container py-3" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
  <div class="d-flex mb-3 justify-content-between">
    <h2>@lang('cars::cars.Cars')</h2>
    <x-btn href="{{ route('cars.create') }}" size="sm" variant="success" icon="bi bi-plus-circle">@lang('cars::cars.Create Car')</x-btn>
  </div>
  <div class="card shadow-sm">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>@lang('cars::cars.Plate Number')</th>
            <th>@lang('cars::cars.Status')</th>
            <th>@lang('cars::cars.Current Employee')</th>
            <th class="text-end">@lang('cars::cars.Actions')</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($cars as $car)
            <tr>
              <td>{{ $car->id }}</td>
              <td>{{ $car->plate_number }}</td>
              <td>{{ $car->status->value }}</td>
              <td>{{ optional($car->currentAssignment?->employee)->first_name }}</td>
              <td class="text-end">
                <x-btn href="{{ route('cars.show',$car) }}" size="sm" variant="outline-secondary" icon="bi bi-eye">@lang('cars::cars.View')</x-btn>
                <x-btn href="{{ route('cars.edit',$car) }}" size="sm" variant="outline-primary" icon="bi bi-pencil"></x-btn>
              </td>
            </tr>
          @empty
            <tr><td colspan="5" class="text-center">@lang('cars::cars.No data')</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-body">{{ $cars->links() }}</div>
  </div>
</div>
@endsection
