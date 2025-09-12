@extends('layouts.master')
@section('title', __('org::companies.Edit Company'))
@section('content')
<div class="container py-3">
  <div class="col-lg-8 mx-auto">
    <div class="card shadow-sm">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">@lang('org::companies.Edit Company')</h5>
        <x-btn href="{{ route('companies.index') }}" size="sm" variant="outline-secondary" icon="bi bi-arrow-right-circle">@lang('org::companies.Back')</x-btn>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('companies.update', $item) }}" class="row g-3">
          @csrf
          @method('PUT')
          <div class="col-md-6">
            <label class="form-label">@lang('org::companies.Name (EN)')</label>
            <input type="text" name="name_en" class="form-control @error('name_en') is-invalid @enderror" value="{{ old('name_en', $item->name_en) }}" required>
            @error('name_en') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">@lang('org::companies.Name (AR)')</label>
            <input type="text" name="name_ar" class="form-control @error('name_ar') is-invalid @enderror" value="{{ old('name_ar', $item->name_ar) }}" required>
            @error('name_ar') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
          <div class="col-md-4">
            <label class="form-label">@lang('org::companies.CR Number')</label>
            <input type="text" name="cr_number" class="form-control @error('cr_number') is-invalid @enderror" value="{{ old('cr_number', $item->cr_number) }}">
            @error('cr_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
          <div class="col-md-4">
            <label class="form-label">@lang('org::companies.VAT Number')</label>
            <input type="text" name="vat_number" class="form-control @error('vat_number') is-invalid @enderror" value="{{ old('vat_number', $item->vat_number) }}">
            @error('vat_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
          <div class="col-md-4">
            <label class="form-label">@lang('org::companies.IBAN')</label>
            <input type="text" name="iban" class="form-control @error('iban') is-invalid @enderror" value="{{ old('iban', $item->iban) }}">
            @error('iban') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
          <div class="col-12 d-flex gap-2">
            <x-btn variant="outline-success" type="submit" icon="bi bi-check2">@lang('users.Save')</x-btn>
            <x-btn href="{{ route('companies.index') }}" variant="outline-secondary">@lang('users.Cancel')</x-btn>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
