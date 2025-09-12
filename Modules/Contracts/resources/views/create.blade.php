@if(View::exists('layouts.master'))
@extends('layouts.master')
@section('title', __('app.New Contract'))
@section('content')
<div class="container py-3" dir="{{ app()->getLocale()=='ar'?'rtl':'ltr' }}">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="mb-0">@lang('app.New Contract')</h2>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('hr.employees.contracts.store', $employee) }}" method="POST" enctype="multipart/form-data" class="row g-3">
                @csrf
                <div class="col-md-4">
                    <label class="form-label">@lang('app.Start')</label>
                    <input type="date" name="start_at" class="form-control" required value="{{ old('start_at') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">@lang('app.End')</label>
                    <input type="date" name="end_at" class="form-control" value="{{ old('end_at') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">@lang('app.Status')</label>
                    <select name="status" class="form-select">
                        <option value="active">active</option>
                        <option value="inactive">inactive</option>
                        <option value="ended">ended</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">@lang('app.Attach')</label>
                    <input type="file" name="attachment" class="form-control">
                </div>
                <div class="col-12">
                    <x-btn type="submit" variant="primary">@lang('app.Save')</x-btn>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@else
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale()=='ar'?'rtl':'ltr' }}">
<body>
<form action="{{ route('hr.employees.contracts.store', $employee) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label>@lang('app.Start')</label><input type="date" name="start_at"><br>
    <label>@lang('app.End')</label><input type="date" name="end_at"><br>
    <button type="submit">@lang('app.Save')</button>
</form>
</body>
</html>
@endif
