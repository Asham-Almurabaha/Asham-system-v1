@extends('layouts.master')
@section('title', __('phones::phones.Phones'))
@section('content')
<div class="container py-3" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item active" aria-current="page">@lang('phones::phones.Phones')</li>
    </ol>
  </nav>
  <div class="d-flex align-items-center justify-content-between mb-3 gap-2 flex-wrap">
    <form method="GET" class="d-flex gap-2 flex-wrap">
      <select name="status" class="form-select form-select-sm">
        <option value="">@lang('phones::common.All Statuses')</option>
        @foreach(\Modules\Phones\Entities\PhoneStatus::cases() as $status)
          <option value="{{ $status->value }}" @selected(request('status')==$status->value)>@lang('phones::statuses.' . $status->value)</option>
        @endforeach
      </select>
      <select name="branch_id" class="form-select form-select-sm">
        <option value="">@lang('phones::phones.Branch')</option>
        @foreach($branches as $branch)
          <option value="{{ $branch->id }}" @selected(request('branch_id')==$branch->id)>{{ $branch->name }}</option>
        @endforeach
      </select>
      <select name="has_line" class="form-select form-select-sm">
        <option value="">@lang('phones::phones.Line Filter')</option>
        <option value="1" @selected(request('has_line')==='1')>@lang('phones::phones.With Line')</option>
        <option value="0" @selected(request('has_line')==='0')>@lang('phones::phones.Without Line')</option>
      </select>
      <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="@lang('phones::common.Search')">
      <x-btn type="submit" size="sm" variant="outline-secondary">@lang('phones::common.Filter')</x-btn>
      <x-btn href="{{ route('phones.index') }}" size="sm" variant="outline-secondary">@lang('phones::common.Reset')</x-btn>
    </form>
    @can('phones.create')
    <x-btn href="{{ route('phones.create') }}" size="sm" variant="success" icon="bi bi-plus-circle">@lang('phones::phones.Create Phone')</x-btn>
    @endcan
  </div>
  <div class="card shadow-sm">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>@lang('phones::phones.IMEI')</th>
            <th>@lang('phones::phones.Brand')</th>
            <th>@lang('phones::phones.Model')</th>
            <th>@lang('phones::phones.Line Number')</th>
            <th>@lang('phones::phones.Status')</th>
            <th>@lang('phones::phones.Current Employee')</th>
            <th>@lang('phones::phones.Branch')</th>
            <th class="text-end">@lang('phones::phones.Actions')</th>
          </tr>
        </thead>
        <tbody>
          @forelse($phones as $phone)
            <tr>
              <td>{{ $phone->id }}</td>
              <td>{{ $phone->imei }}</td>
              <td>{{ $phone->brand }}</td>
              <td>{{ $phone->model }}</td>
              <td>{{ $phone->line_number }}</td>
              <td>
                @php $cls = match($phone->status->value){ 'available'=>'success','assigned'=>'warning','maintenance'=>'info','retired'=>'secondary'}; @endphp
                <span class="badge bg-{{ $cls }}-subtle text-{{ $cls }} border">@lang('phones::statuses.' . $phone->status->value)</span>
              </td>
              <td>
                {{ optional($phone->currentAssignment?->employee)->name }}
                @if($phone->assignments->count())
                  <a href="{{ route('phones.assignments.history', $phone) }}" class="ms-1">@lang('phones::assignments.History')</a>
                @endif
              </td>
              <td>{{ $phone->branch?->name }}</td>
              <td class="text-end">
                <div class="d-inline-flex gap-1">
                  @can('phones.view')
                    <x-btn href="{{ route('phones.show',$phone) }}" size="sm" variant="outline-secondary" icon="bi bi-eye"></x-btn>
                  @endcan
                  @can('phones.update')
                    <x-btn href="{{ route('phones.edit',$phone) }}" size="sm" variant="outline-primary" icon="bi bi-pencil"></x-btn>
                  @endcan
                  @can('phones.delete')
                    <x-btn href="{{ route('phones.destroy',$phone) }}" method="DELETE" size="sm" variant="outline-danger" icon="bi bi-trash" confirm="@lang('phones::common.Delete confirm')"></x-btn>
                  @endcan
                  @if(!$phone->currentAssignment)
                    @can('phones.assign')
                      <x-btn href="{{ route('phones.assignments.store',$phone) }}" method="POST" size="sm" variant="outline-success" icon="bi bi-box-arrow-in-right"></x-btn>
                    @endcan
                  @else
                    @can('phones.return')
                      <x-btn href="{{ route('phones.assignments.return',[$phone,$phone->currentAssignment]) }}" method="POST" size="sm" variant="outline-warning" icon="bi bi-box-arrow-left"></x-btn>
                    @endcan
                  @endif
                </div>
              </td>
            </tr>
          @empty
            <tr><td colspan="9" class="text-center text-muted">@lang('phones::phones.No data')</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-body">{{ $phones->withQueryString()->links() }}</div>
  </div>
</div>
@endsection
