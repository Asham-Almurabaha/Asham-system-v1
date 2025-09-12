@if(View::exists('layouts.master'))
@extends('layouts.master')
@section('title', __('app.Assets'))
@section('content')
<div class="container py-3" dir="{{ app()->getLocale()=='ar'?'rtl':'ltr' }}">
    <x-btn href="{{ route('hr.assets.create') }}" size="sm" variant="success" icon="bi bi-plus-circle">@lang('app.New')</x-btn>
    <table class="table mt-3">
        <tr><th>ID</th><th>@lang('app.Type')</th><th>@lang('app.Status')</th><th></th></tr>
        @foreach($items as $a)
        <tr>
            <td>{{ $a->id }}</td>
            <td>{{ $a->type }}</td>
            <td>{{ $a->status }}</td>
            <td class="text-end">
                <x-btn href="{{ route('hr.assets.edit', $a) }}" size="sm" variant="outline-primary" icon="bi bi-pencil" />
                <x-btn href="{{ route('hr.assets.destroy', $a) }}" method="DELETE" size="sm" variant="outline-danger" icon="bi bi-trash">@lang('app.Delete')</x-btn>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
@else
<!DOCTYPE html><html lang="{{ app()->getLocale() }}"><body>@lang('app.Assets')</body></html>
@endif
