@if(View::exists('layouts.master'))
@extends('layouts.master')
@section('title', __('app.Leaves'))
@section('content')
<div class="container py-3" dir="{{ app()->getLocale()=='ar'?'rtl':'ltr' }}">
    <h5>@lang('app.Leaves')</h5>
    <table class="table mt-3">
        <tr><th>@lang('app.Employee')</th><th>@lang('app.Date')</th><th>@lang('app.Days')</th><th>@lang('app.Status')</th></tr>
        @foreach($items as $l)
        <tr>
            <td>{{ $l->employee?->first_name }}</td>
            <td>{{ $l->start_at }} - {{ $l->end_at }}</td>
            <td>{{ $l->days }}</td>
            <td><span class="badge bg-info text-dark">{{ $l->status }}</span></td>
        </tr>
        @endforeach
    </table>
    {{ $items->links() }}
</div>
@endsection
@else
<!DOCTYPE html><html lang="{{ app()->getLocale() }}"><body>@lang('app.Leaves')</body></html>
@endif
