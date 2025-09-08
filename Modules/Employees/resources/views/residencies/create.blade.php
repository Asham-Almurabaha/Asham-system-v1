@extends('layouts.master')
@section('title', __('employees::employees.Create Residency'))
@section('content')
<div class="container py-3">
  <div class="col-lg-8 mx-auto">
    <div class="card shadow-sm">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">@lang('employees::employees.Create Residency')</h5>
        <x-btn href="{{ route('employees.show', $employee) }}" size="sm" variant="outline-secondary" icon="bi bi-arrow-right-circle">@lang('employees::employees.Back')</x-btn>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('employees.residencies.store', $employee) }}" enctype="multipart/form-data" class="row g-3">
          @csrf
          <div class="col-md-6">
            <label class="form-label">@lang('employees::employees.Absher ID Image')</label>
            <input type="file" name="absher_id_image" class="form-control @error('absher_id_image') is-invalid @enderror">
            @error('absher_id_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">@lang('employees::employees.Tawakkalna ID Image')</label>
            <input type="file" name="tawakkalna_id_image" class="form-control @error('tawakkalna_id_image') is-invalid @enderror">
            @error('tawakkalna_id_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">@lang('employees::employees.Expiry Date')</label>
            <input type="date" name="expiry_date" class="form-control @error('expiry_date') is-invalid @enderror" value="{{ old('expiry_date') }}" required>
            @error('expiry_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">@lang('employees::employees.Employer Name')</label>
            <input type="text" name="employer_name" class="form-control @error('employer_name') is-invalid @enderror" value="{{ old('employer_name') }}">
            @error('employer_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">@lang('employees::employees.Employer ID')</label>
            <input type="text" name="employer_id" class="form-control @error('employer_id') is-invalid @enderror" value="{{ old('employer_id') }}">
            @error('employer_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
          <div class="col-12 d-flex gap-2">
            <x-btn variant="outline-success" type="submit" icon="bi bi-check2">@lang('users.Save')</x-btn>
            <x-btn href="{{ route('employees.show', $employee) }}" variant="outline-secondary">@lang('users.Cancel')</x-btn>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
