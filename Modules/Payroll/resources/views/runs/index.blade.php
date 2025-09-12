@if(View::exists('layouts.master'))
@extends('layouts.master')
@section('title', __('app.Payroll Runs'))
@section('content')
<div class="container py-3" dir="{{ app()->getLocale()=='ar'?'rtl':'ltr' }}">
    <x-btn href="{{ route('hr.payroll-runs.create') }}" size="sm" variant="success" icon="bi bi-plus-circle">@lang('app.New')</x-btn>
    <table class="table mt-3">
        <tr><th>ID</th><th>@lang('app.Month')</th><th>@lang('app.Status')</th><th></th></tr>
        @foreach($runs as $r)
        <tr>
            <td>{{ $r->id }}</td>
            <td>{{ $r->month }}</td>
            <td>{{ $r->status }}</td>
            <td><a href="{{ route('hr.payroll-runs.show', $r) }}">@lang('app.View')</a></td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
@else
<!DOCTYPE html><html lang="{{ app()->getLocale() }}"><body>@lang('app.Payroll Runs')</body></html>
@endif
