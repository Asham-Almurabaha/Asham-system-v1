@if(View::exists('layouts.master'))
@extends('layouts.master')
@section('title', __('app.Request Leave'))
@section('content')
<div class="container py-3" dir="{{ app()->getLocale()=='ar'?'rtl':'ltr' }}">
    <form action="{{ route('hr.leaves.store', $employee) }}" method="POST" class="row g-2">
        @csrf
        <div class="col-12"><select name="leave_type_id" class="form-select">@foreach($types as $t)<option value="{{ $t->id }}">{{ $t->name }}</option>@endforeach</select></div>
        <div class="col-6"><input type="date" name="start_at" class="form-control" required></div>
        <div class="col-6"><input type="date" name="end_at" class="form-control" required></div>
        <div class="col-12"><input type="number" step="0.5" name="days" class="form-control" required></div>
        <div class="col-12"><textarea name="reason" class="form-control" placeholder="reason"></textarea></div>
        <div class="col-12"><x-btn type="submit" variant="primary">@lang('app.Save')</x-btn></div>
    </form>
</div>
@endsection
@else
<!DOCTYPE html><html lang="{{ app()->getLocale() }}"><body>@lang('app.Request Leave')</body></html>
@endif
