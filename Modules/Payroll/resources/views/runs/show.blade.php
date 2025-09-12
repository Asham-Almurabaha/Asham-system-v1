@if(View::exists('layouts.master'))
@extends('layouts.master')
@section('title', __('app.Payroll Runs'))
@section('content')
<div class="container py-3" dir="{{ app()->getLocale()=='ar'?'rtl':'ltr' }}">
    <h5>@lang('app.Payroll') #{{ $run->id }}</h5>
    @if($run->status === 'draft')
    <form action="{{ route('hr.payroll.post', $run) }}" method="POST" class="d-inline">@csrf<x-btn type="submit" variant="primary">@lang('app.Post')</x-btn></form>
    @endif
    <a href="{{ route('hr.payroll.export_wps', $run) }}" class="btn btn-secondary btn-sm">@lang('app.Export WPS')</a>

    <table class="table mt-3">
        <tr><th>@lang('app.Employee')</th><th>@lang('app.Basic')</th><th>@lang('app.Net')</th></tr>
        @foreach($run->items as $it)
        <tr><td>{{ $it->employee?->first_name }}</td><td>{{ $it->basic }}</td><td>{{ $it->net }}</td></tr>
        @endforeach
    </table>

    @include('payroll::items._form')
</div>
@endsection
@else
<!DOCTYPE html><html lang="{{ app()->getLocale() }}"><body>@lang('app.Payroll Runs')</body></html>
@endif
