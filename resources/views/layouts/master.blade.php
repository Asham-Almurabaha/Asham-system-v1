<!DOCTYPE html>
@php 
  $isRtl = app()->getLocale() === 'ar'; 
@endphp
<html lang="{{ $isRtl ? 'ar' : 'en' }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
<head>
  @include('layouts.head')
</head>
<body>

  @if (Auth::check())
    <!-- Header -->
    <header id="header" class="header fixed-top d-flex align-items-center">
      @include('layouts.header')
    </header>

    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar">
      @include('layouts.sidebar')
    </aside>
  @endif

  <main id="main" class="main">
    @if (session()->has('success') || $errors->any())
      {{-- فلاش الرسائل --}}
      @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show shadow" role="alert" aria-live="polite" id="flash-success"
             style="position: fixed; top: 70px; {{ app()->getLocale()==='ar'?'left':'right' }}: 20px; z-index: 9999;">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('app.close') }}"></button>
        </div>
      @endif

      @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow" role="alert" aria-live="polite" id="flash-error"
             style="position: fixed; top: 70px; {{ app()->getLocale()==='ar'?'left':'right' }}: 20px; z-index: 9999;">
          <ul class="mb-0">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('app.close') }}"></button>
        </div>
      @endif
    @endif

    @yield('content')
  </main>

  @include('layouts.script')
</body>
</html>
