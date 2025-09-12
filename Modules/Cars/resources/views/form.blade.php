@extends('layouts.master')
@section('title', $car->exists ? __('cars::cars.Edit Car') : __('cars::cars.Create Car'))
@section('content')
<div class="container py-3" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
  <form method="POST" action="{{ $car->exists ? route('cars.update',$car) : route('cars.store') }}">
    @csrf
    @if($car->exists) @method('PUT') @endif
    <div class="mb-3">
      <label class="form-label">@lang('cars::cars.Plate Number')</label>
      <input type="text" name="plate_number" value="{{ old('plate_number',$car->plate_number) }}" class="form-control" />
    </div>
    <div class="mb-3">
      <label class="form-label">@lang('cars::cars.VIN')</label>
      <input type="text" name="vin" value="{{ old('vin',$car->vin) }}" class="form-control" />
    </div>
    <div class="mb-3">
      <label class="form-label">@lang('cars::cars.Year')</label>
      <input type="number" name="year" value="{{ old('year',$car->year) }}" class="form-control" />
    </div>
    <div class="mb-3">
      <label class="form-label">@lang('cars::cars.Brand')</label>
      <input type="text" name="brand" value="{{ old('brand',$car->brand) }}" class="form-control" />
    </div>
    <div class="mb-3">
      <label class="form-label">@lang('cars::cars.Model')</label>
      <input type="text" name="model" value="{{ old('model',$car->model) }}" class="form-control" />
    </div>
    <div class="mb-3">
      <label class="form-label">@lang('cars::cars.Color')</label>
      <input type="text" name="color" value="{{ old('color',$car->color) }}" class="form-control" />
    </div>
    <div class="mb-3">
      <label class="form-label">@lang('cars::cars.Status')</label>
      <select name="status" class="form-select">
        @foreach(\Modules\Cars\Entities\CarStatus::cases() as $status)
          <option value="{{ $status->value }}" @selected(old('status',$car->status->value ?? '')==$status->value)>{{ $status->value }}</option>
        @endforeach
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">@lang('cars::cars.Purchase Date')</label>
      <input type="date" name="purchase_date" value="{{ old('purchase_date',optional($car->purchase_date)->format('Y-m-d')) }}" class="form-control" />
    </div>
    <div class="mb-3">
      <label class="form-label">@lang('cars::cars.Cost')</label>
      <input type="number" step="0.01" name="cost" value="{{ old('cost',$car->cost) }}" class="form-control" />
    </div>
    <div class="mb-3">
      <label class="form-label">@lang('cars::cars.Notes')</label>
      <textarea name="notes" class="form-control">{{ old('notes',$car->notes) }}</textarea>
    </div>
    <x-btn type="submit" variant="primary">@lang('cars::cars.Save')</x-btn>
  </form>
</div>
@endsection
