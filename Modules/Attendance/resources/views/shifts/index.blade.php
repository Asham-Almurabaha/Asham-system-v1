@if(View::exists('layouts.master'))
@extends('layouts.master')
@section('title', __('app.Shifts'))
@section('content')
<div class="container py-3" dir="{{ app()->getLocale()=='ar'?'rtl':'ltr' }}">
    <x-btn href="{{ route('hr.shifts.create') }}" variant="success" size="sm" icon="bi bi-plus-circle">@lang('app.Shifts')</x-btn>
    <table class="table mt-3">
        <tr><th>ID</th><th>@lang('app.Name')</th><th>@lang('app.Start')</th><th>@lang('app.End')</th><th></th></tr>
        @foreach($items as $i)
        <tr>
            <td>{{ $i->id }}</td>
            <td>{{ $i->name }}</td>
            <td>{{ $i->start_time }}</td>
            <td>{{ $i->end_time }}</td>
            <td class="text-end">
                <x-btn href="{{ route('hr.shifts.edit', $i) }}" size="sm" variant="outline-primary" icon="bi bi-pencil" />
                <x-btn href="{{ route('hr.shifts.destroy', $i) }}" method="DELETE" size="sm" variant="outline-danger" icon="bi bi-trash">@lang('app.Delete')</x-btn>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
@else
<!DOCTYPE html><html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale()=='ar'?'rtl':'ltr' }}"><body>
<h3>@lang('app.Shifts')</h3>
</body></html>
@endif
