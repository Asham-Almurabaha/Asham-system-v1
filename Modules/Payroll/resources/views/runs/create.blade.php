@if(View::exists('layouts.master'))
@extends('layouts.master')
@section('title', __('app.Payroll Runs'))
@section('content')
<div class="container py-3" dir="{{ app()->getLocale()=='ar'?'rtl':'ltr' }}">
    <form action="{{ route('hr.payroll-runs.store') }}" method="POST" class="row g-2">
        @csrf
        <div class="col-6"><input type="month" name="month" class="form-control" required></div>
        <div class="col-6"><select name="company_id" class="form-select">@foreach($companies as $c)<option value="{{ $c->id }}">{{ $c->name_en }}</option>@endforeach</select></div>
        <div class="col-12"><x-btn type="submit" variant="primary">@lang('app.Save')</x-btn></div>
    </form>
</div>
@endsection
@else
<!DOCTYPE html><html lang="{{ app()->getLocale() }}"><body>@lang('app.Payroll Runs')</body></html>
@endif
