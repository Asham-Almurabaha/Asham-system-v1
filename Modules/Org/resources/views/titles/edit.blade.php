@extends('layouts.master')
@section('title', __('org::titles.Edit Title'))
@section('content')
<div class="container py-3">
  <div class="col-lg-8 mx-auto">
    <div class="card shadow-sm">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">@lang('org::titles.Edit Title')</h5>
        <x-btn href="{{ route('titles.index') }}" size="sm" variant="outline-secondary" icon="bi bi-arrow-right-circle">@lang('org::titles.Back')</x-btn>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('titles.update', $item) }}" class="row g-3">
          @csrf
          @method('PUT')
          <div class="col-md-4">
            <label class="form-label">@lang('org::titles.Company')</label>
            <select name="company_id" class="form-select @error('company_id') is-invalid @enderror">
              <option value="">--</option>
              @foreach($companies as $c)
                <option value="{{ $c->id }}" @selected(old('company_id', $item->company_id)==$c->id)>{{ $c->name_en }}</option>
              @endforeach
            </select>
            @error('company_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
          <div class="col-md-4">
            <label class="form-label">@lang('org::titles.Branch')</label>
            <select name="branch_id" class="form-select @error('branch_id') is-invalid @enderror">
              <option value="">--</option>
              @foreach($branches as $b)
                <option value="{{ $b->id }}" @selected(old('branch_id', $item->branch_id)==$b->id)>{{ $b->name_en }}</option>
              @endforeach
            </select>
            @error('branch_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
          <div class="col-md-4">
            <label class="form-label">@lang('org::titles.Department')</label>
            <select name="department_id" class="form-select @error('department_id') is-invalid @enderror">
              <option value="">--</option>
              @foreach($departments as $d)
                <option value="{{ $d->id }}" @selected(old('department_id', $item->department_id)==$d->id)>{{ $d->name_en }}</option>
              @endforeach
            </select>
            @error('department_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">@lang('org::titles.Name (EN)')</label>
            <input type="text" name="name_en" class="form-control @error('name_en') is-invalid @enderror" value="{{ old('name_en', $item->name_en) }}" required>
            @error('name_en') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">@lang('org::titles.Name (AR)')</label>
            <input type="text" name="name_ar" class="form-control @error('name_ar') is-invalid @enderror" value="{{ old('name_ar', $item->name_ar) }}" required>
            @error('name_ar') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
          <div class="col-12 form-check">
            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" {{ old('is_active', $item->is_active) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">@lang('org::titles.Active')</label>
          </div>
          <div class="col-12 d-flex gap-2">
            <x-btn variant="outline-success" type="submit" icon="bi bi-check2">@lang('users.Save')</x-btn>
            <x-btn href="{{ route('titles.index') }}" variant="outline-secondary">@lang('users.Cancel')</x-btn>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
