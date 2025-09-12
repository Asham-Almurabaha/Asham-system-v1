@extends('layouts.master')
@section('title', __('phones::phones.Phones'))
@section('content')
<div class="container py-3" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
  <div class="d-flex mb-3 justify-content-between">
    <h2>@lang('phones::phones.Phones')</h2>
    <x-btn href="{{ route('phones.create') }}" size="sm" variant="success" icon="bi bi-plus-circle">@lang('phones::phones.Create Phone')</x-btn>
  </div>
  <div class="card shadow-sm">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>@lang('phones::phones.IMEI')</th>
            <th>@lang('phones::phones.Status')</th>
            <th>@lang('phones::phones.Current Employee')</th>
            <th class="text-end">@lang('phones::phones.Actions')</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($phones as $phone)
            <tr>
              <td>{{ $phone->id }}</td>
              <td>{{ $phone->imei }}</td>
              <td>{{ $phone->status->value }}</td>
              <td>{{ optional($phone->currentAssignment?->employee)->first_name }}</td>
              <td class="text-end">
                <x-btn href="{{ route('phones.show',$phone) }}" size="sm" variant="outline-secondary" icon="bi bi-eye">@lang('phones::phones.View')</x-btn>
                <x-btn href="{{ route('phones.edit',$phone) }}" size="sm" variant="outline-primary" icon="bi bi-pencil"></x-btn>
              </td>
            </tr>
          @empty
            <tr><td colspan="5" class="text-center">@lang('phones::phones.No data')</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-body">{{ $phones->links() }}</div>
  </div>
</div>
@endsection
