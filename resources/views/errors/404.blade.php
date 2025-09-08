@extends('layouts.app')

@section('title', '404')
@section('auth_subtitle', __('الصفحة غير موجودة'))

@section('form')
<div class="d-flex justify-content-center align-items-center py-4 py-md-5">
  <div class="card shadow-sm border-0 rounded-4" style="max-width: 480px; width: 100%;">
    <div class="card-body p-4 p-md-5 text-center">

      {{-- أيقونة خطأ --}}
      <div class="mx-auto mb-4 d-flex align-items-center justify-content-center rounded-circle bg-danger bg-opacity-10 text-danger" style="width:70px; height:70px;">
        <i class="bi bi-exclamation-triangle-fill fs-1"></i>
      </div>

      {{-- العنوان --}}
      <h1 class="h3 fw-bold mb-2">404</h1>
      <p class="text-muted mb-4">{{ __('عذرًا، الصفحة التي تبحث عنها غير موجودة') }}</p>

      {{-- زر العودة --}}
      <a href="{{ url('/') }}" class="btn btn-primary w-100 rounded-3">
        {{ __('العودة إلى الرئيسية') }}
      </a>
    </div>
  </div>
</div>
@endsection
