@extends('layouts.master')
@section('title', __('cars::cars.Cars'))
@section('content')
<div class="container py-3" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item active" aria-current="page">@lang('cars::cars.Cars')</li>
    </ol>
  </nav>
  <div class="d-flex align-items-center justify-content-between mb-3 gap-2 flex-wrap">
    {{-- Filter form removed temporarily --}}
    @can('cars.create')
    <x-btn href="{{ route('cars.create') }}" size="sm" variant="success" icon="bi bi-plus-circle">@lang('cars::cars.Create Car')</x-btn>
    @endcan
  </div>
  <div class="card shadow-sm">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>@lang('cars::cars.Plate Number')</th>
            <th>@lang('cars::cars.Sequence Number')</th>
            <th>@lang('cars::cars.Brand')</th>
            <th>@lang('cars::cars.Model')</th>
            <th>@lang('cars::cars.Year')</th>
            <th>@lang('cars::cars.Color')</th>
            <th>@lang('cars::cars.Status')</th>
            <th>@lang('cars::cars.Current Employee')</th>
            <th>@lang('cars::cars.Branch')</th>
            <th class="text-end">@lang('cars::cars.Actions')</th>
          </tr>
        </thead>
        <tbody>
          @forelse($cars as $car)
            <tr>
              <td>{{ $car->id }}</td>
              <td>{{ $car->plate_number }}</td>
              <td>{{ $car->sequence_number }}</td>
              <td>{{ $car->brand?->{app()->getLocale() === 'ar' ? 'name_ar' : 'name_en'} }}</td>
              <td>{{ $car->model?->{app()->getLocale() === 'ar' ? 'name_ar' : 'name_en'} }}</td>
              <td>{{ $car->year?->year }}</td>
              <td>{{ $car->color?->{app()->getLocale() === 'ar' ? 'name_ar' : 'name_en'} }}</td>
              <td>
                @php $cls = match($car->status?->name_en){
                  'available' => 'success',
                  'assigned' => 'warning',
                  'maintenance' => 'info',
                  'retired' => 'secondary',
                }; @endphp
                <span class="badge bg-{{ $cls }}-subtle text-{{ $cls }} border">@lang('cars::statuses.' . $car->status?->name_en)</span>
              </td>
              <td>
                {{ optional($car->currentAssignment?->employee)->name }}
                @if($car->assignments->count())
                  <a href="{{ route('cars.assignments.history', $car) }}" class="ms-1">@lang('cars::assignments.History')</a>
                @endif
              </td>
              <td>{{ $car->branch?->name }}</td>
              <td class="text-end">
                <div class="d-inline-flex gap-1">
                  @can('cars.view')
                    <x-btn href="{{ route('cars.show',$car) }}" size="sm" variant="outline-secondary" icon="bi bi-eye"></x-btn>
                  @endcan
                  @can('cars.update')
                    <x-btn href="{{ route('cars.edit',$car) }}" size="sm" variant="outline-primary" icon="bi bi-pencil"></x-btn>
                  @endcan
                  @can('cars.delete')
                    <x-btn href="{{ route('cars.destroy',$car) }}" method="DELETE" size="sm" variant="outline-danger" icon="bi bi-trash" confirm="@lang('cars::common.Delete confirm')"></x-btn>
                  @endcan
                  @if(!$car->currentAssignment)
                    @can('cars.assign')
                      <x-btn href="{{ route('cars.assignments.store',$car) }}" method="POST" size="sm" variant="outline-success" icon="bi bi-box-arrow-in-right"></x-btn>
                    @endcan
                  @else
                    @can('cars.return')
                      <x-btn href="{{ route('cars.assignments.return',[$car,$car->currentAssignment]) }}" method="POST" size="sm" variant="outline-warning" icon="bi bi-box-arrow-left"></x-btn>
                    @endcan
                  @endif
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="11" class="text-center text-muted">@lang('cars::cars.No data')</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-body">{{ $cars->withQueryString()->links() }}</div>
  </div>
</div>
@endsection
