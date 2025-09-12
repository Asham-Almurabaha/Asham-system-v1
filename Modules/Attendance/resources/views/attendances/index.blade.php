@if(View::exists('layouts.master'))
@extends('layouts.master')
@section('title', __('app.Attendance'))
@section('content')
<div class="container py-3" dir="{{ app()->getLocale()=='ar'?'rtl':'ltr' }}">
    <h5>@lang('app.Attendance')</h5>
    <table class="table">
        <tr><th>@lang('app.Employee')</th><th>@lang('app.Check In')</th><th>@lang('app.Check Out')</th><th>@lang('app.Source')</th></tr>
        @foreach($items as $a)
        <tr>
            <td>{{ $a->employee?->first_name }}</td>
            <td>{{ $a->check_in_at }}</td>
            <td>{{ $a->check_out_at }}</td>
            <td>{{ $a->source }}</td>
        </tr>
        @endforeach
    </table>
    {{ $items->links() }}
</div>
@endsection
@else
<!DOCTYPE html><html lang="{{ app()->getLocale() }}"><body>@lang('app.Attendance')</body></html>
@endif
