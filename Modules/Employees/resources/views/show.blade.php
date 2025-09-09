@extends('layouts.master')

@section('title', __('employees::employees.View Employee'))

@section('content')
@php
    use Illuminate\Support\Str;
    $locale = app()->getLocale();

    // دوال مساعدة سريعة للعرض
    $t = fn ($bool, $yes, $no) => $bool ? $yes : $no;
    $fmtDate = fn ($date) => optional($date)?->format('Y-m-d') ?? __('employees::employees.Not set');
    $tr = function ($rel, $enKey = 'name', $arKey = 'name_ar') use ($locale) {
        return $rel ? ($locale === 'ar' ? ($rel->{$arKey} ?? $rel->{$enKey}) : ($rel->{$enKey} ?? $rel->{$arKey})) : __('employees::employees.Not set');
    };

    // صورة/أفاتار
    $hasPhoto = filled($item->photo_url);
    $initials = Str::of(($item->first_name ?? ' ') . ' ' . ($item->last_name ?? ' '))
                    ->trim()
                    ->split('/\s+/')
                    ->take(2)
                    ->map(fn($p) => Str::upper(Str::substr($p, 0, 1)))
                    ->implode('');
@endphp

<div class="container py-3">
  <div class="col-12 col-lg-10 mx-auto">

    {{-- Breadcrumbs بسيطة --}}
    <nav aria-label="breadcrumb" class="mb-3">
      <ol class="breadcrumb small">
        <li class="breadcrumb-item">
          <a href="{{ route('employees.index') }}">@lang('employees::employees.Employees')</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
          @lang('employees::employees.View Employee')
        </li>
      </ol>
    </nav>

    <div class="card shadow-sm border-0">
      <div class="card-header bg-white border-0 pt-3 pb-0">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
          <h5 class="mb-2 mb-md-0">
            @lang('employees::employees.View Employee')
          </h5>

          <div class="d-flex gap-2">
            <x-btn href="{{ route('employees.index') }}"
                   size="sm" variant="outline-secondary"
                   icon="bi bi-arrow-right-circle">
              @lang('employees::employees.Back')
            </x-btn>

            @if(Route::has('employees.edit'))
              <x-btn href="{{ route('employees.edit', $item) }}"
                     size="sm" variant="outline-primary"
                     icon="bi bi-pencil-square">
                @lang('employees::employees.Edit')
              </x-btn>
            @endif

            <x-btn href="javascript:window.print()"
                   size="sm" variant="outline-dark"
                   icon="bi bi-printer">
              @lang('employees::employees.Print')
            </x-btn>
          </div>
        </div>
        <hr class="mt-3 mb-0">
      </div>

      <div class="card-body">

        {{-- رأس البطاقة: صورة/أفاتار + اسم + حالة --}}
        <div class="d-flex align-items-center gap-3 mb-4">
          @if($hasPhoto)
            <img src="{{ $item->photo_url }}"
                 alt="@lang('employees::employees.Photo')"
                 class="rounded border" style="width:84px;height:84px;object-fit:cover;">
          @else
            <div class="rounded-circle d-inline-flex align-items-center justify-content-center border bg-light"
                 style="width:84px;height:84px;">
              <span class="fw-bold text-muted">{{ $initials ?: '—' }}</span>
            </div>
          @endif

          <div class="flex-grow-1">
            <div class="d-flex align-items-center gap-2 flex-wrap">
              <h5 class="mb-0">
                {{ trim(($item->first_name ?? '') . ' ' . ($item->last_name ?? '')) ?: __('employees::employees.Employee') }}
              </h5>
              <span class="badge {{ $item->is_active ? 'bg-success' : 'bg-secondary' }}">
                {{ $item->is_active ? __('employees::employees.Active') : __('employees::employees.Inactive') }}
              </span>
            </div>

            <div class="text-muted small mt-1">
              {{-- عرض العنوان والفرع والقسم إن وجدوا --}}
              <span class="me-2">
                <i class="bi bi-person-badge"></i>
                {{ $tr($item->title) }}
              </span>
              <span class="me-2">•</span>
              <span class="me-2">
                <i class="bi bi-diagram-3"></i>
                {{ $tr($item->department) }}
              </span>
              <span class="me-2">•</span>
              <span>
                <i class="bi bi-geo-alt"></i>
                {{ $tr($item->branch) }}
              </span>
            </div>
          </div>
        </div>

        {{-- معلومات أساسية (تعريفية) --}}
        <div class="row g-3">
          <div class="col-12 col-lg-6">
            <div class="card h-100 border-0 shadow-sm">
              <div class="card-header bg-white border-0 pb-0">
                <h6 class="mb-0">@lang('employees::employees.Basic Info')</h6>
                <hr class="mt-2 mb-0">
              </div>
              <div class="card-body">
                <dl class="row mb-0 small">
                  <dt class="col-5">@lang('employees::employees.First Name (EN)')</dt>
                  <dd class="col-7">{{ $item->first_name ?? '—' }}</dd>

                  <dt class="col-5">@lang('employees::employees.First Name (AR)')</dt>
                  <dd class="col-7">{{ $item->first_name_ar ?? '—' }}</dd>

                  <dt class="col-5">@lang('employees::employees.Last Name (EN)')</dt>
                  <dd class="col-7">{{ $item->last_name ?? '—' }}</dd>

                  <dt class="col-5">@lang('employees::employees.Last Name (AR)')</dt>
                  <dd class="col-7">{{ $item->last_name_ar ?? '—' }}</dd>

                  <dt class="col-5">@lang('employees::employees.Nationality')</dt>
                  <dd class="col-7">{{ $tr($item->nationality) }}</dd>

                  <dt class="col-5">@lang('employees::employees.Hire Date')</dt>
                  <dd class="col-7">{{ $fmtDate($item->hire_date) }}</dd>
                </dl>
              </div>
            </div>
          </div>

          <div class="col-12 col-lg-6">
            <div class="card h-100 border-0 shadow-sm">
              <div class="card-header bg-white border-0 pb-0">
                <h6 class="mb-0">@lang('employees::employees.Contact')</h6>
                <hr class="mt-2 mb-0">
              </div>
              <div class="card-body">
                <dl class="row mb-0 small">
                  <dt class="col-5">@lang('employees::employees.Email')</dt>
                  <dd class="col-7">
                    @if($item->email)
                      <a href="mailto:{{ $item->email }}" class="text-decoration-none">
                        <i class="bi bi-envelope-open me-1"></i>{{ $item->email }}
                      </a>
                    @else
                      —
                    @endif
                  </dd>

                  <dt class="col-5">@lang('employees::employees.Phone Numbers')</dt>
                  <dd class="col-7">
                    @if($item->phones?->count())
                      <div class="d-flex flex-wrap gap-1">
                        @foreach($item->phones as $ph)
                          <span class="badge text-bg-light border">
                            <a class="text-decoration-none" href="tel:{{ $ph->phone }}">{{ $ph->phone }}</a>
                          </span>
                        @endforeach
                      </div>
                    @else
                      —
                    @endif
                  </dd>

                  <dt class="col-5">@lang('employees::employees.Branch')</dt>
                  <dd class="col-7">{{ $tr($item->branch) }}</dd>

                  <dt class="col-5">@lang('employees::employees.Department')</dt>
                  <dd class="col-7">{{ $tr($item->department) }}</dd>

                  <dt class="col-5">@lang('employees::employees.Title')</dt>
                  <dd class="col-7">{{ $tr($item->title) }}</dd>
                </dl>
              </div>
            </div>
          </div>
        </div>

        {{-- الإقامات --}}
        <div class="d-flex align-items-center justify-content-between mb-2 mt-4">
          <h6 class="mb-0">@lang('employees::employees.Residencies')</h6>
          <x-btn href="{{ route('employees.residencies.create', $item) }}"
                 size="sm" variant="outline-primary" icon="bi bi-plus-circle">
            @lang('employees::employees.Add Residency')
          </x-btn>
        </div>

        @if($item->residencies->isEmpty())
          <div class="border rounded-3 p-4 text-center text-muted bg-light-subtle">
            <i class="bi bi-inboxes fs-3 d-block mb-2"></i>
            <div>@lang('employees::employees.No data')</div>
          </div>
        @else
          <div class="table-responsive">
            <table class="table align-middle table-hover">
              <thead class="table-light">
                <tr>
                  <th style="width: 180px;">@lang('employees::employees.Expiry Date')</th>
                  <th>@lang('employees::employees.Employer Name')</th>
                  <th class="text-center" style="width: 160px;">@lang('employees::employees.Status')</th>
                </tr>
              </thead>
              <tbody>
                @foreach($item->residencies as $residency)
                  @php
                    $exp = $residency->expiry_date;
                    $isExpired = $exp && $exp->isPast();
                    $days = $exp ? now()->diffInDays($exp, false) : null;
                    $badge = $isExpired ? 'bg-danger' : (($days !== null && $days <= 30) ? 'bg-warning text-dark' : 'bg-success');
                    $statusText = $isExpired
                        ? __('employees::employees.Expired')
                        : (($days !== null && $days <= 30)
                            ? __('employees::employees.Expiring Soon')
                            : __('employees::employees.Valid'));
                  @endphp
                  <tr>
                    <td>
                      <span class="fw-semibold">{{ $fmtDate($exp) }}</span>
                      @if($days !== null)
                        <small class="text-muted ms-1">
                          ({{ $days >= 0 ? __('employees::employees.in_days', ['n' => $days]) : __('employees::employees.days_ago', ['n' => abs($days)]) }})
                        </small>
                      @endif
                    </td>
                    <td>{{ $residency->employer_name ?: '—' }}</td>
                    <td class="text-center">
                      <span class="badge {{ $badge }}">{{ $statusText }}</span>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @endif

      </div>
    </div>
  </div>
</div>
@endsection
