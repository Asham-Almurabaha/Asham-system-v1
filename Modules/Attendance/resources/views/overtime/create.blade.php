@if(View::exists('layouts.master'))
@extends('layouts.master')
@section('title', __('app.Overtime'))
@section('content')
<div class="container py-3" dir="{{ app()->getLocale()=='ar'?'rtl':'ltr' }}">
    <form action="{{ route('hr.overtime.store') }}" method="POST" class="row g-2">
        @csrf
        <div class="col-auto"><select name="employee_id" class="form-select">@foreach($employees as $e)<option value="{{ $e->id }}">{{ $e->first_name }}</option>@endforeach</select></div>
        <div class="col-auto"><input type="date" name="date" class="form-control" required></div>
        <div class="col-auto"><input type="number" name="minutes" class="form-control" required></div>
        <div class="col-auto"><x-btn type="submit" variant="primary">@lang('app.Save')</x-btn></div>
    </form>
</div>
@endsection
@else
<!DOCTYPE html><html lang="{{ app()->getLocale() }}"><body>@lang('app.Overtime')</body></html>
@endif
