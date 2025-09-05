@props([
  'href' => null,
  'method' => null,        // GET|POST|PUT|PATCH|DELETE
  'variant' => 'primary',  // primary|secondary|success|danger|outline-*
  'size' => null,          // sm|lg|null
  'icon' => null,          // e.g. "bi bi-check2"
  'confirm' => null,       // confirm message
  'type' => null,          // for <button>
])

@php
  $isOutline = str_starts_with($variant, 'outline-');
  $variantClass = $isOutline ? 'btn-'. $variant : 'btn-' . $variant;
  $sizeClass = $size === 'sm' ? 'btn-sm' : ($size === 'lg' ? 'btn-lg' : '');
  $btnClasses = trim("btn {$variantClass} {$sizeClass}");
  $iconClasses = $icon;
  $btnLabel = trim($slot);
  $http = strtoupper($method ?? 'GET');
@endphp

@if($href && ($http === 'GET'))
  <a href="{{ $href }}"
     @if($confirm) onclick="return confirm(@js($confirm))" @endif
     {{ $attributes->merge(['class' => $btnClasses]) }}>
    @if($iconClasses)
      <i class="{{ $iconClasses }} me-1"></i>
    @endif
    {{ $btnLabel }}
  </a>
@elseif($href && ($http !== 'GET'))
  <form action="{{ $href }}" method="POST" class="d-inline"
        @if($confirm) onsubmit="return confirm(@js($confirm))" @endif>
    @csrf
    @if(!in_array($http, ['GET','POST']))
      @method($http)
    @endif
    <button type="submit" {{ $attributes->merge(['class' => $btnClasses]) }}>
      @if($iconClasses)
        <i class="{{ $iconClasses }} me-1"></i>
      @endif
      {{ $btnLabel }}
    </button>
  </form>
@else
  <button type="{{ $type ?? 'button' }}" {{ $attributes->merge(['class' => $btnClasses]) }}>
    @if($iconClasses)
      <i class="{{ $iconClasses }} me-1"></i>
    @endif
    {{ $btnLabel }}
  </button>
@endif

