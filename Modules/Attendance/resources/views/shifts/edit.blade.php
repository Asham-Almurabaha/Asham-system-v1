@if(View::exists('layouts.master'))
@extends('layouts.master')
@section('title', __('app.Shifts'))
@section('content')
<div class="container py-3" dir="{{ app()->getLocale()=='ar'?'rtl':'ltr' }}">
    <form action="{{ route('hr.shifts.update', $item) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-2"><label class="form-label">@lang('app.Name')</label><input type="text" name="name" class="form-control" value="{{ $item->name }}" required></div>
        <div class="mb-2"><label class="form-label">@lang('app.Start')</label><input type="time" name="start_time" class="form-control" value="{{ $item->start_time }}" required></div>
        <div class="mb-2"><label class="form-label">@lang('app.End')</label><input type="time" name="end_time" class="form-control" value="{{ $item->end_time }}" required></div>
        <div class="mb-2"><label class="form-label">@lang('app.Break')</label><input type="number" name="break_minutes" class="form-control" value="{{ $item->break_minutes }}" required></div>
        <x-btn type="submit" variant="primary">@lang('app.Save')</x-btn>
    </form>
</div>
@endsection
@else
<!DOCTYPE html><html lang="{{ app()->getLocale() }}"><body>
<form action="{{ route('hr.shifts.update', $item) }}" method="POST">@csrf @method('PUT')<input name="name" value="{{ $item->name }}"/><button>@lang('app.Save')</button></form>
</body></html>
@endif
