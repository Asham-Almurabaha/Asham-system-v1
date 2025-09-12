@if(View::exists('layouts.master'))
@extends('layouts.master')
@section('title', __('app.Overtime'))
@section('content')
<div class="container py-3" dir="{{ app()->getLocale()=='ar'?'rtl':'ltr' }}">
    <h5>@lang('app.Overtime')</h5>
    <x-btn href="{{ route('hr.overtime.create') }}" size="sm" variant="success" icon="bi bi-plus">@lang('app.Overtime')</x-btn>
    <table class="table mt-3">
        <tr><th>@lang('app.Employee')</th><th>@lang('app.Date')</th><th>@lang('app.Minutes')</th><th>@lang('app.Status')</th><th></th></tr>
        @foreach($items as $o)
        <tr>
            <td>{{ $o->employee?->first_name }}</td>
            <td>{{ $o->date }}</td>
            <td>{{ $o->minutes }}</td>
            <td>{{ $o->status }}</td>
            <td class="text-end">
                <form action="{{ route('hr.overtime.approve', $o->id) }}" method="POST" class="d-inline">@csrf<x-btn type="submit" size="sm" variant="outline-success">@lang('app.Approve')</x-btn></form>
                <form action="{{ route('hr.overtime.reject', $o->id) }}" method="POST" class="d-inline">@csrf<x-btn type="submit" size="sm" variant="outline-danger">@lang('app.Reject')</x-btn></form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
@else
<!DOCTYPE html><html lang="{{ app()->getLocale() }}"><body>@lang('app.Overtime')</body></html>
@endif
