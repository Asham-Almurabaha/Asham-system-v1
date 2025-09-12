@extends('layouts.master')
@section('title', $motorcycle->exists ? __('motorcycles::motorcycles.Edit Motorcycle') : __('motorcycles::motorcycles.Create Motorcycle'))
@section('content')
<div class="container py-3" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
  <form method="POST" action="{{ $motorcycle->exists ? route('motorcycles.update',$motorcycle) : route('motorcycles.store') }}">
    @csrf
    @if($motorcycle->exists) @method('PUT') @endif
    <div class="mb-3">
      <label class="form-label">@lang('motorcycles::motorcycles.Plate Number')</label>
      <input type="text" name="plate_number" value="{{ old('plate_number',$motorcycle->plate_number) }}" class="form-control" />
    </div>
    <div class="mb-3">
      <label class="form-label">@lang('motorcycles::motorcycles.Chassis Number')</label>
      <input type="text" name="chassis_number" value="{{ old('chassis_number',$motorcycle->chassis_number) }}" class="form-control" />
    </div>
    <div class="mb-3">
      <label class="form-label">@lang('motorcycles::motorcycles.Year')</label>
      <input type="number" name="year" value="{{ old('year',$motorcycle->year) }}" class="form-control" />
    </div>
    <div class="mb-3">
      <label class="form-label">@lang('motorcycles::motorcycles.Brand')</label>
      <input type="text" name="brand" value="{{ old('brand',$motorcycle->brand) }}" class="form-control" />
    </div>
    <div class="mb-3">
      <label class="form-label">@lang('motorcycles::motorcycles.Model')</label>
      <input type="text" name="model" value="{{ old('model',$motorcycle->model) }}" class="form-control" />
    </div>
    <div class="mb-3">
      <label class="form-label">@lang('motorcycles::motorcycles.Color')</label>
      <input type="text" name="color" value="{{ old('color',$motorcycle->color) }}" class="form-control" />
    </div>
    <div class="mb-3">
      <label class="form-label">@lang('motorcycles::motorcycles.Status')</label>
      <select name="status" class="form-select">
        @foreach(\Modules\Motorcycles\Entities\MotorcycleStatus::cases() as $status)
          <option value="{{ $status->value }}" @selected(old('status',$motorcycle->status->value ?? '')==$status->value)>{{ $status->value }}</option>
        @endforeach
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">@lang('motorcycles::motorcycles.Purchase Date')</label>
      <input type="date" name="purchase_date" value="{{ old('purchase_date',optional($motorcycle->purchase_date)->format('Y-m-d')) }}" class="form-control" />
    </div>
    <div class="mb-3">
      <label class="form-label">@lang('motorcycles::motorcycles.Cost')</label>
      <input type="number" step="0.01" name="cost" value="{{ old('cost',$motorcycle->cost) }}" class="form-control" />
    </div>
    <div class="mb-3">
      <label class="form-label">@lang('motorcycles::motorcycles.Notes')</label>
      <textarea name="notes" class="form-control">{{ old('notes',$motorcycle->notes) }}</textarea>
    </div>
    <x-btn type="submit" variant="primary">@lang('motorcycles::motorcycles.Save')</x-btn>
  </form>
</div>
@endsection
