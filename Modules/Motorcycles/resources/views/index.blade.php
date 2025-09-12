@extends('layouts.master')
@section('title', __('motorcycles::motorcycles.Motorcycles'))
@section('content')
<div class="container py-3" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item active" aria-current="page">@lang('motorcycles::motorcycles.Motorcycles')</li>
    </ol>
  </nav>
  <div class="d-flex align-items-center justify-content-between mb-3 gap-2 flex-wrap">
    <form method="GET" class="d-flex gap-2 flex-wrap">
      <select name="status" class="form-select form-select-sm">
        <option value="">@lang('motorcycles::common.All Statuses')</option>
        @foreach(\Modules\Motorcycles\Entities\MotorcycleStatus::cases() as $status)
          <option value="{{ $status->value }}" @selected(request('status')==$status->value)>@lang('motorcycles::statuses.' . $status->value)</option>
        @endforeach
      </select>
      <select name="branch_id" class="form-select form-select-sm">
        <option value="">@lang('motorcycles::motorcycles.Branch')</option>
        @foreach($branches as $branch)
          <option value="{{ $branch->id }}" @selected(request('branch_id')==$branch->id)>{{ $branch->name }}</option>
        @endforeach
      </select>
      <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="@lang('motorcycles::common.Search')">
      <x-btn type="submit" size="sm" variant="outline-secondary">@lang('motorcycles::common.Filter')</x-btn>
      <x-btn href="{{ route('motorcycles.index') }}" size="sm" variant="outline-secondary">@lang('motorcycles::common.Reset')</x-btn>
    </form>
    @can('motorcycles.create')
    <x-btn href="{{ route('motorcycles.create') }}" size="sm" variant="success" icon="bi bi-plus-circle">@lang('motorcycles::motorcycles.Create Motorcycle')</x-btn>
    @endcan
  </div>
  <div class="card shadow-sm">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>@lang('motorcycles::motorcycles.Plate Number')</th>
            <th>@lang('motorcycles::motorcycles.Chassis Number')</th>
            <th>@lang('motorcycles::motorcycles.Brand')</th>
            <th>@lang('motorcycles::motorcycles.Model')</th>
            <th>@lang('motorcycles::motorcycles.Year')</th>
            <th>@lang('motorcycles::motorcycles.Status')</th>
            <th>@lang('motorcycles::motorcycles.Current Employee')</th>
            <th>@lang('motorcycles::motorcycles.Branch')</th>
            <th class="text-end">@lang('motorcycles::motorcycles.Actions')</th>
          </tr>
        </thead>
        <tbody>
          @forelse($motorcycles as $motorcycle)
            <tr>
              <td>{{ $motorcycle->id }}</td>
              <td>{{ $motorcycle->plate_number }}</td>
              <td>{{ $motorcycle->chassis_number }}</td>
              <td>{{ $motorcycle->brand }}</td>
              <td>{{ $motorcycle->model }}</td>
              <td>{{ $motorcycle->year }}</td>
              <td>
                @php $cls = match($motorcycle->status->value){ 'available'=>'success','assigned'=>'warning','maintenance'=>'info','retired'=>'secondary'}; @endphp
                <span class="badge bg-{{ $cls }}-subtle text-{{ $cls }} border">@lang('motorcycles::statuses.' . $motorcycle->status->value)</span>
              </td>
              <td>
                {{ optional($motorcycle->currentAssignment?->employee)->name }}
                @if($motorcycle->assignments->count())
                  <a href="{{ route('motorcycles.assignments.history', $motorcycle) }}" class="ms-1">@lang('motorcycles::assignments.History')</a>
                @endif
              </td>
              <td>{{ $motorcycle->branch?->name }}</td>
              <td class="text-end">
                <div class="d-inline-flex gap-1">
                  @can('motorcycles.view')
                    <x-btn href="{{ route('motorcycles.show',$motorcycle) }}" size="sm" variant="outline-secondary" icon="bi bi-eye"></x-btn>
                  @endcan
                  @can('motorcycles.update')
                    <x-btn href="{{ route('motorcycles.edit',$motorcycle) }}" size="sm" variant="outline-primary" icon="bi bi-pencil"></x-btn>
                  @endcan
                  @can('motorcycles.delete')
                    <x-btn href="{{ route('motorcycles.destroy',$motorcycle) }}" method="DELETE" size="sm" variant="outline-danger" icon="bi bi-trash" confirm="@lang('motorcycles::common.Delete confirm')"></x-btn>
                  @endcan
                  @if(!$motorcycle->currentAssignment)
                    @can('motorcycles.assign')
                      <x-btn href="{{ route('motorcycles.assignments.store',$motorcycle) }}" method="POST" size="sm" variant="outline-success" icon="bi bi-box-arrow-in-right"></x-btn>
                    @endcan
                  @else
                    @can('motorcycles.return')
                      <x-btn href="{{ route('motorcycles.assignments.return',[$motorcycle,$motorcycle->currentAssignment]) }}" method="POST" size="sm" variant="outline-warning" icon="bi bi-box-arrow-left"></x-btn>
                    @endcan
                  @endif
                </div>
              </td>
            </tr>
          @empty
            <tr><td colspan="10" class="text-center text-muted">@lang('motorcycles::motorcycles.No data')</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-body">{{ $motorcycles->withQueryString()->links() }}</div>
  </div>
</div>
@endsection
