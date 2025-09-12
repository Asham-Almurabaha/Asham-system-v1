@if(View::exists('layouts.master'))
@extends('layouts.master')
@section('title', __('documents::documents.documents'))
@section('content')
<div class="container py-3" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    @include('documents::_list', ['employee' => $employee, 'documents' => $documents])
</div>
@endsection
@else
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<body>
@include('documents::_list', ['employee' => $employee, 'documents' => $documents])
</body>
</html>
@endif
