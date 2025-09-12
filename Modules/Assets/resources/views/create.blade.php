@if(View::exists('layouts.master'))
@extends('layouts.master')
@section('title', __('app.Assets'))
@section('content')
<div class="container py-3" dir="{{ app()->getLocale()=='ar'?'rtl':'ltr' }}">
    <form action="{{ isset($item) ? route('hr.assets.update', $item) : route('hr.assets.store') }}" method="POST">
        @csrf
        @if(isset($item)) @method('PUT') @endif
        <div class="mb-2"><label class="form-label">@lang('app.Type')</label><input type="text" name="type" class="form-control" value="{{ $item->type ?? '' }}" required></div>
        <div class="mb-2"><label class="form-label">Serial</label><input type="text" name="serial" class="form-control" value="{{ $item->serial ?? '' }}"></div>
        <div class="mb-2"><label class="form-label">@lang('app.Status')</label><input type="text" name="status" class="form-control" value="{{ $item->status ?? '' }}"></div>
        <x-btn type="submit" variant="primary">@lang('app.Save')</x-btn>
    </form>
</div>
@endsection
@else
<!DOCTYPE html><html lang="{{ app()->getLocale() }}"><body>@lang('app.Assets')</body></html>
@endif
