@extends('layouts.master')
@section('title', __('cars::documents.Documents'))
@section('content')
<div class="container py-3" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="{{ route('cars.index') }}">@lang('cars::cars.Cars')</a></li>
      <li class="breadcrumb-item"><a href="{{ route('cars.show', $car) }}">{{ $car->plate_number }}</a></li>
      <li class="breadcrumb-item active" aria-current="page">@lang('cars::documents.Documents')</li>
    </ol>
  </nav>
  <div class="col-lg-10 mx-auto">
    <div class="card shadow-sm mb-3">
      <div class="card-header">@lang('cars::documents.Add Document')</div>
      <div class="card-body">
        <form method="POST" action="{{ route('cars.documents.store', $car) }}">
          @csrf
          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label">@lang('cars::documents.Type')</label>
              <select name="car_document_data_type_id" class="form-select @error('car_document_data_type_id') is-invalid @enderror">
                @foreach($types as $type)
                  <option value="{{ $type->id }}" @selected(old('car_document_data_type_id') == $type->id)>{{ app()->getLocale() === 'ar' ? $type->name_ar : $type->name_en }}</option>
                @endforeach
              </select>
              @error('car_document_data_type_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
              <label class="form-label">@lang('cars::documents.Value')</label>
              <input type="text" name="value" value="{{ old('value') }}" class="form-control @error('value') is-invalid @enderror">
              @error('value')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-2">
              <label class="form-label">@lang('cars::documents.Start Date')</label>
              <input type="date" name="start_date" value="{{ old('start_date') }}" class="form-control @error('start_date') is-invalid @enderror">
              @error('start_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-2">
              <label class="form-label">@lang('cars::documents.End Date')</label>
              <input type="date" name="end_date" value="{{ old('end_date') }}" class="form-control @error('end_date') is-invalid @enderror">
              @error('end_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="mt-3">
            <x-btn type="submit" variant="primary" size="sm">@lang('cars::common.Save')</x-btn>
          </div>
        </form>
      </div>
    </div>
    <div class="card shadow-sm">
      <div class="card-header">@lang('cars::documents.Documents')</div>
      <div class="card-body">
        <table class="table table-sm">
          <thead>
            <tr>
              <th>@lang('cars::documents.Type')</th>
              <th>@lang('cars::documents.Value')</th>
              <th>@lang('cars::documents.Start Date')</th>
              <th>@lang('cars::documents.End Date')</th>
              <th>@lang('cars::cars.Actions')</th>
            </tr>
          </thead>
          <tbody>
            @forelse($documents as $doc)
              <tr>
                <td>{{ app()->getLocale() === 'ar' ? $doc->dataType->name_ar : $doc->dataType->name_en }}</td>
                <td>{{ $doc->value }}</td>
                <td>{{ optional($doc->start_date)->format('Y-m-d') }}</td>
                <td>{{ optional($doc->end_date)->format('Y-m-d') }}</td>
                <td>
                  <form method="POST" action="{{ route('cars.documents.destroy', [$car, $doc]) }}" onsubmit="return confirm('@lang('cars::common.Delete confirm')');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center">@lang('cars::cars.No data')</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
