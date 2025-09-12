@extends('layouts.master')
@section('title', $phone->exists ? __('phones::phones.Edit Phone') : __('phones::phones.Create Phone'))
@section('content')
<div class="container py-3" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
  <form method="POST" action="{{ $phone->exists ? route('phones.update',$phone) : route('phones.store') }}">
    @csrf
    @if($phone->exists) @method('PUT') @endif
    <div class="mb-3">
      <label class="form-label">@lang('phones::phones.IMEI')</label>
      <input type="text" name="imei" value="{{ old('imei',$phone->imei) }}" class="form-control" />
    </div>
    <div class="mb-3">
      <label class="form-label">@lang('phones::phones.Serial Number')</label>
      <input type="text" name="serial_number" value="{{ old('serial_number',$phone->serial_number) }}" class="form-control" />
    </div>
    <div class="mb-3">
      <label class="form-label">@lang('phones::phones.Brand')</label>
      <input type="text" name="brand" value="{{ old('brand',$phone->brand) }}" class="form-control" />
    </div>
    <div class="mb-3">
      <label class="form-label">@lang('phones::phones.Model')</label>
      <input type="text" name="model" value="{{ old('model',$phone->model) }}" class="form-control" />
    </div>
    <div class="mb-3">
      <label class="form-label">@lang('phones::phones.Color')</label>
      <input type="text" name="color" value="{{ old('color',$phone->color) }}" class="form-control" />
    </div>
    <div class="mb-3">
      <label class="form-label">@lang('phones::phones.Line Number')</label>
      <input type="text" name="line_number" value="{{ old('line_number',$phone->line_number) }}" class="form-control" />
    </div>
    <div class="mb-3">
      <label class="form-label">@lang('phones::phones.Status')</label>
      <select name="status" class="form-select">
        @foreach(\Modules\Phones\Entities\PhoneStatus::cases() as $status)
          <option value="{{ $status->value }}" @selected(old('status',$phone->status->value ?? '')==$status->value)>{{ $status->value }}</option>
        @endforeach
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">@lang('phones::phones.Purchase Date')</label>
      <input type="date" name="purchase_date" value="{{ old('purchase_date',optional($phone->purchase_date)->format('Y-m-d')) }}" class="form-control" />
    </div>
    <div class="mb-3">
      <label class="form-label">@lang('phones::phones.Cost')</label>
      <input type="number" step="0.01" name="cost" value="{{ old('cost',$phone->cost) }}" class="form-control" />
    </div>
    <div class="mb-3">
      <label class="form-label">@lang('phones::phones.Notes')</label>
      <textarea name="notes" class="form-control">{{ old('notes',$phone->notes) }}</textarea>
    </div>
    <x-btn type="submit" variant="primary">@lang('phones::phones.Save')</x-btn>
  </form>
</div>
@endsection
