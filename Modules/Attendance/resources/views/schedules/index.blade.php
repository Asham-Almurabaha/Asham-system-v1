@if(View::exists('layouts.master'))
@extends('layouts.master')
@section('title', __('app.Schedules'))
@section('content')
<div class="container py-3" dir="{{ app()->getLocale()=='ar'?'rtl':'ltr' }}">
    <h5>@lang('app.Schedules')</h5>
    <form class="row g-2" action="{{ route('hr.employees.schedules.store', $employee) }}" method="POST">
        @csrf
        <div class="col-auto"><input type="date" name="date" class="form-control" required></div>
        <div class="col-auto"><select name="shift_id" class="form-select">@foreach($shifts as $s)<option value="{{ $s->id }}">{{ $s->name }}</option>@endforeach</select></div>
        <div class="col-auto"><x-btn type="submit" variant="primary">@lang('app.Save')</x-btn></div>
    </form>
    <table class="table mt-3">
        <tr><th>@lang('app.Date')</th><th>@lang('app.Shifts')</th></tr>
        @foreach($schedules as $sc)
        <tr><td>{{ $sc->date->format('Y-m-d') }}</td><td>{{ $sc->shift?->name }}</td></tr>
        @endforeach
    </table>
</div>
@endsection
@else
<!DOCTYPE html><html lang="{{ app()->getLocale() }}"><body>
@lang('app.Schedules')
</body></html>
@endif
