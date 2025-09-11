@extends('layouts.master')

@section('title', __('employees::employees.View Employee'))

@section('content')
@php
    use Illuminate\Support\Str;

    $locale = app()->getLocale();

    // ====== Name (auto-pick by locale with graceful fallback)
    $first = $locale === 'ar' ? ($item->first_name_ar ?? $item->first_name) : ($item->first_name ?? $item->first_name_ar);
    $last  = $locale === 'ar' ? ($item->last_name_ar  ?? $item->last_name)  : ($item->last_name  ?? $item->last_name_ar);
    $displayName = trim(($first ?? '') . ' ' . ($last ?? '')) ?: __('employees::employees.Employee');

    // ====== Helpers
    $fmtDate = fn ($date) => optional($date)?->format('Y-m-d') ?? __('employees::employees.Not set');
    $tr = function ($rel, $enKey = 'name', $arKey = 'name_ar') use ($locale) {
        return $rel
            ? ($locale === 'ar' ? ($rel->{$arKey} ?? $rel->{$enKey}) : ($rel->{$enKey} ?? $rel->{$arKey}))
            : __('employees::employees.Not set');
    };

    // ====== Avatar
    $hasPhoto = filled($item->photo_url);
    $initials = Str::of(($first ?? ' ') . ' ' . ($last ?? ' '))
                    ->trim()
                    ->split('/\s+/')
                    ->take(2)
                    ->map(fn($p) => Str::upper(Str::substr($p, 0, 1)))
                    ->implode('');

    // ====== Active residency detection (either explicit is_active or unexpired)
    $activeResidency = $item->residencies->first(function ($r) {
        $exp = $r->expiry_date; // Carbon|null
        $byDate = $exp && $exp->isFuture();
        $byFlag = \property_exists($r, 'is_active') ? (bool)$r->is_active : false;
        return $byFlag || $byDate;
    });

    // Use active if available, else the first record
    $residency = $activeResidency ?: $item->residencies->first();
    $activeResidencyId = $activeResidency?->id;

    // Small utility for status labeling
    $statusBadge = function ($days) {
        if ($days === null) return ['text-bg-secondary', __('employees::employees.Not set')];
        if ($days < 0)      return ['text-bg-danger',   __('employees::employees.Expired')];
        if ($days <= 30)    return ['text-bg-warning',  __('employees::employees.Expiring Soon')];
        return ['text-bg-success', __('employees::employees.Valid')];
    };
@endphp

<div class="container py-3">
  <div class="col-12 col-lg-10 mx-auto">

    {{-- Breadcrumbs --}}
    <nav aria-label="breadcrumb" class="mb-3">
      <ol class="breadcrumb small mb-0">
        <li class="breadcrumb-item">
          <a href="{{ route(Route::has('hr.employees.index') ? 'hr.employees.index' : 'employees.index') }}" class="text-decoration-none">
            @lang('employees::employees.Employees')
          </a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
          @lang('employees::employees.View Employee')
        </li>
      </ol>
    </nav>

    {{-- ================= Header / Summary Card ================= --}}
    <div class="card shadow-sm border-0 mb-3">
      <div class="card-header bg-white border-0 py-3">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
          <div class="d-flex align-items-center gap-2">
            <h5 class="mb-0">@lang('employees::employees.View Employee')</h5>
            <span class="text-muted small">#{{ $item->id }}</span>
          </div>
          <div class="btn-group" role="group" aria-label="Actions">
            <x-btn href="{{ route(Route::has('hr.employees.index') ? 'hr.employees.index' : 'employees.index') }}" size="sm" variant="outline-secondary" icon="bi bi-arrow-right-circle">
              @lang('employees::employees.Back')
            </x-btn>
            @if(Route::has('employees.edit'))
              <x-btn href="{{ route(Route::has('hr.employees.edit') ? 'hr.employees.edit' : 'employees.edit', $item) }}" size="sm" variant="outline-primary" icon="bi bi-pencil-square">
                @lang('employees::employees.Edit')
              </x-btn>
            @endif
          </div>
        </div>
      </div>

      <div class="card-body">
        <div class="d-flex align-items-center gap-3 flex-wrap">
          {{-- Photo --}}
          @if($hasPhoto)
            <img
              src="{{ $item->photo_url }}"
              alt="@lang('employees::employees.Photo')"
              class="rounded border employee-avatar"
              width="96" height="96"
              loading="eager" decoding="async" fetchpriority="high"
              style="width:var(--avatar-size,72px);height:var(--avatar-size,72px);object-fit:cover;"
              onerror="this.classList.add('d-none'); document.getElementById('avatar-fallback')?.classList.remove('d-none');"
            >
          @endif

          {{-- Avatar fallback --}}
          <div id="avatar-fallback"
               class="rounded-circle d-inline-flex align-items-center justify-content-center border bg-light {{ $hasPhoto ? 'd-none' : '' }}"
               style="width:var(--avatar-size,72px);height:var(--avatar-size,72px);">
            <span class="fw-bold text-muted" aria-hidden="true">{{ $initials ?: '—' }}</span>
          </div>

          <div class="flex-grow-1 min-w-0">
            <div class="d-flex align-items-center gap-2 flex-wrap">
              <h4 class="mb-0 text-truncate" title="{{ $displayName }}">{{ $displayName }}</h4>
              <span class="badge {{ $item->is_active ? 'text-bg-success' : 'text-bg-secondary' }}">
                {{ $item->is_active ? __('employees::employees.Active') : __('employees::employees.Inactive') }}
              </span>
            </div>

            <ul class="list-inline text-muted small mt-1 mb-0 d-flex flex-wrap align-items-center gap-2">
              @if($item->title)
                <li class="list-inline-item d-inline-flex align-items-center gap-1">
                  <i class="bi bi-person-badge" aria-hidden="true"></i><span>{{ $tr($item->title) }}</span>
                </li>
                <li class="text-muted">•</li>
              @endif

              @if($item->department)
                <li class="list-inline-item d-inline-flex align-items-center gap-1">
                  <i class="bi bi-diagram-3" aria-hidden="true"></i><span>{{ $tr($item->department) }}</span>
                </li>
                <li class="text-muted">•</li>
              @endif

              @if($item->branch)
                <li class="list-inline-item d-inline-flex align-items-center gap-1">
                  <i class="bi bi-geo-alt" aria-hidden="true"></i><span>{{ $tr($item->branch) }}</span>
                </li>
              @endif
            </ul>
          </div>
        </div>
      </div>
    </div>

    {{-- ================= Basic Info ================= --}}
    <div class="card shadow-sm border-0 mb-3">
      <div class="card-header bg-white border-0 py-3">
        <h6 class="mb-0">@lang('employees::employees.Basic Info')</h6>
      </div>
      <div class="card-body">
        <dl class="row mb-0 small">
          <dt class="col-12 col-md-4 col-lg-3">@lang('employees::employees.First Name (EN)')</dt>
          <dd class="col-12 col-md-8 col-lg-9">{{ $item->first_name ?? '—' }}</dd>

          <dt class="col-12 col-md-4 col-lg-3">@lang('employees::employees.First Name (AR)')</dt>
          <dd class="col-12 col-md-8 col-lg-9">{{ $item->first_name_ar ?? '—' }}</dd>

          <dt class="col-12 col-md-4 col-lg-3">@lang('employees::employees.Last Name (EN)')</dt>
          <dd class="col-12 col-md-8 col-lg-9">{{ $item->last_name ?? '—' }}</dd>

          <dt class="col-12 col-md-4 col-lg-3">@lang('employees::employees.Last Name (AR)')</dt>
          <dd class="col-12 col-md-8 col-lg-9">{{ $item->last_name_ar ?? '—' }}</dd>

          <dt class="col-12 col-md-4 col-lg-3">@lang('employees::employees.Nationality')</dt>
          <dd class="col-12 col-md-8 col-lg-9">{{ $tr($item->nationality) }}</dd>

          <dt class="col-12 col-md-4 col-lg-3">@lang('employees::employees.Hire Date')</dt>
          <dd class="col-12 col-md-8 col-lg-9">{{ $fmtDate($item->hire_date) }}</dd>
        </dl>
      </div>
    </div>

    {{-- ================= Contact ================= --}}
    <div class="card shadow-sm border-0 mb-3">
      <div class="card-header bg-white border-0 py-3">
        <h6 class="mb-0">@lang('employees::employees.Contact')</h6>
      </div>
      <div class="card-body">
        <dl class="row mb-0 small">
          <dt class="col-12 col-md-4 col-lg-3">@lang('employees::employees.Email')</dt>
          <dd class="col-12 col-md-8 col-lg-9">
            @if($item->email)
              <a href="mailto:{{ $item->email }}" class="text-decoration-none">
                <i class="bi bi-envelope-open me-1" aria-hidden="true"></i>
                <span class="text-break">{{ $item->email }}</span>
              </a>
            @else
              —
            @endif
          </dd>

          <dt class="col-12 col-md-4 col-lg-3">@lang('employees::employees.Phone Numbers')</dt>
          <dd class="col-12 col-md-8 col-lg-9">
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

          <dt class="col-12 col-md-4 col-lg-3">@lang('employees::employees.Branch')</dt>
          <dd class="col-12 col-md-8 col-lg-9">{{ $tr($item->branch) }}</dd>

          <dt class="col-12 col-md-4 col-lg-3">@lang('employees::employees.Department')</dt>
          <dd class="col-12 col-md-8 col-lg-9">{{ $tr($item->department) }}</dd>

          <dt class="col-12 col-md-4 col-lg-3">@lang('employees::employees.Title')</dt>
          <dd class="col-12 col-md-8 col-lg-9">{{ $tr($item->title) }}</dd>
        </dl>
      </div>
    </div>

    {{-- ================= Identity (Active Residency if exists) ================= --}}
    <div class="card shadow-sm border-0 mb-3">
      <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
        <h6 class="mb-0">@lang('employees::employees.Identity Data')</h6>
        <x-btn href="{{ route('employees.residencies.create', $item) }}" size="sm" variant="outline-primary" icon="bi bi-plus-circle">
          @lang('employees::employees.Add Residency')
        </x-btn>
      </div>
      <div class="card-body">
        @if(!$residency || (!$residency->absher_id_image && !$residency->tawakkalna_id_image && !$residency->expiry_date && !$residency->employer_name && !$residency->employer_id))
          <div class="border rounded-3 p-4 text-center text-muted bg-light-subtle">
            <i class="bi bi-inboxes fs-3 d-block mb-2" aria-hidden="true"></i>
            <div>@lang('employees::employees.No data')</div>
          </div>
        @else
          @php
            $expA   = $residency->expiry_date; // Carbon|null
            $daysA  = $expA ? today()->diffInDays($expA->endOfDay(), false) : null; // int|null
            [$badgeA, $statusTextA] = $statusBadge($daysA);
            $absherA = $residency->absher_id_image ? Storage::url($residency->absher_id_image) : null;
            $tawakA  = $residency->tawakkalna_id_image ? Storage::url($residency->tawakkalna_id_image) : null;
          @endphp

          <dl class="row small mb-3">
            <dt class="col-12 col-md-3">@lang('employees::employees.Employer Name')</dt>
            <dd class="col-12 col-md-9 text-truncate" title="{{ $residency->employer_name }}">{{ $residency->employer_name ?: '—' }}</dd>

            <dt class="col-12 col-md-3">@lang('employees::employees.Employer ID')</dt>
            <dd class="col-12 col-md-9">
              @if($residency->employer_id)
                <span class="font-monospace me-2" id="active-employer-id">{{ $residency->employer_id }}</span>
                <button type="button" class="btn btn-outline-secondary btn-sm js-copy" data-target="#active-employer-id" title="@lang('app.copy')">
                  <i class="bi bi-clipboard" aria-hidden="true"></i>
                </button>
              @else
                —
              @endif
            </dd>

            <dt class="col-12 col-md-3">@lang('employees::employees.Residency Expiry Date')</dt>
            <dd class="col-12 col-md-9">
              {{ $fmtDate($expA) }}
              @if($daysA !== null)
                <div class="text-muted mt-1">
                  @if($locale === 'ar')
                    @if($daysA > 0)
                      الباقي في الإقامة: {{ (int) $daysA }} يوم
                    @elseif($daysA === 0)
                      ينتهي اليوم
                    @else
                      انتهت منذ {{ (int) abs($daysA) }} يوم
                    @endif
                  @else
                    @if($daysA > 0)
                      Remaining: {{ (int) $daysA }} day{{ $daysA == 1 ? '' : 's' }}
                    @elseif($daysA === 0)
                      Expires today
                    @else
                      Ended {{ (int) abs($daysA) }} day{{ abs($daysA) == 1 ? '' : 's' }} ago
                    @endif
                  @endif
                </div>
              @endif
            </dd>

            <dt class="col-12 col-md-3">@lang('employees::employees.Status')</dt>
            <dd class="col-12 col-md-9">
              <span class="badge {{ $badgeA }}">{{ $statusTextA }}</span>
            </dd>
          </dl>

          {{-- ID Images (Absher / Tawakkalna) --}}
          <div class="row g-3">
            @if($absherA)
              <div class="col-sm-6">
                <label class="form-label small text-muted d-block mb-2">@lang('employees::employees.Absher ID Image')</label>
                <a href="{{ $absherA }}" target="_blank" class="id-thumb d-inline-flex" rel="noopener noreferrer">
                  <img src="{{ $absherA }}" alt="@lang('employees::employees.Absher ID Image')" loading="lazy" decoding="async" referrerpolicy="no-referrer" onerror="this.classList.add('d-none')">
                </a>
              </div>
            @endif
            @if($tawakA)
              <div class="col-sm-6">
                <label class="form-label small text-muted d-block mb-2">@lang('employees::employees.Tawakkalna ID Image')</label>
                <a href="{{ $tawakA }}" target="_blank" class="id-thumb d-inline-flex" rel="noopener noreferrer">
                  <img src="{{ $tawakA }}" alt="@lang('employees::employees.Tawakkalna ID Image')" loading="lazy" decoding="async" referrerpolicy="no-referrer" onerror="this.classList.add('d-none')">
                </a>
              </div>
            @endif
          </div>
        @endif
      </div>
    </div>

    {{-- ================= Residencies (excluding active) ================= --}}
    <div class="card shadow-sm border-0 mb-3">
      <div class="card-header bg-white border-0 py-3">
        <h6 class="mb-0">@lang('employees::employees.Residencies')</h6>
      </div>
      <div class="card-body">
        @php $residenciesForTable = $item->residencies->filter(fn($r) => $r->id !== $activeResidencyId); @endphp

        @if($residenciesForTable->isEmpty())
          <div class="border rounded-3 p-4 text-center text-muted bg-light-subtle">
            <i class="bi bi-inboxes fs-3 d-block mb-2" aria-hidden="true"></i>
            <div>@lang('employees::employees.No data')</div>
          </div>
        @else
          <div class="table-responsive">
            <table class="table align-middle table-hover mb-0">
              <thead class="table-light">
                <tr>
                  <th style="width: 180px;">@lang('employees::employees.Expiry Date')</th>
                  <th>@lang('employees::employees.Employer Name')</th>
                  <th style="width: 170px;">@lang('employees::employees.Employer ID')</th>
                  <th class="text-center" style="width: 160px;">@lang('employees::employees.Status')</th>
                  <th class="th-id-images">@lang('employees::employees.ID Images')</th>
                </tr>
              </thead>
              <tbody>
                @foreach($residenciesForTable as $residencyRow)
                  @php
                    $exp   = $residencyRow->expiry_date; // Carbon|null
                    $days  = $exp ? today()->diffInDays($exp->endOfDay(), false) : null; // int|null
                    [$badge, $statusText] = $statusBadge($days);
                    $absherUrl = $residencyRow->absher_id_image ? Storage::url($residencyRow->absher_id_image) : null;
                    $tawakUrl  = $residencyRow->tawakkalna_id_image ? Storage::url($residencyRow->tawakkalna_id_image) : null;
                  @endphp
                  <tr>
                    <td>
                      <span class="fw-semibold">{{ $fmtDate($exp) }}</span>
                      @if($days !== null)
                        <div class="small text-muted mt-1">
                          @if($locale === 'ar')
                            @if($days > 0)
                              الباقي في الإقامة: {{ (int) $days }} يوم
                            @elseif($days === 0)
                              ينتهي اليوم
                            @else
                              انتهت منذ {{ (int) abs($days) }} يوم
                            @endif
                          @else
                            @if($days > 0)
                              Remaining: {{ (int) $days }} day{{ $days == 1 ? '' : 's' }}
                            @elseif($days === 0)
                              Expires today
                            @else
                              Ended {{ (int) abs($days) }} day{{ abs($days) == 1 ? '' : 's' }} ago
                            @endif
                          @endif
                        </div>
                      @endif
                    </td>

                    <td class="text-truncate" style="max-width: 260px;" title="{{ $residencyRow->employer_name }}">
                      {{ $residencyRow->employer_name ?: '—' }}
                    </td>

                    <td>
                      @if($residencyRow->employer_id)
                        <span class="font-monospace me-2" id="employer-{{ $residencyRow->id }}">{{ $residencyRow->employer_id }}</span>
                        <button type="button" class="btn btn-outline-secondary btn-sm js-copy" data-target="#employer-{{ $residencyRow->id }}" title="@lang('app.copy')">
                          <i class="bi bi-clipboard" aria-hidden="true"></i>
                        </button>
                      @else
                        —
                      @endif
                    </td>

                    <td class="text-center">
                      <span class="badge {{ $badge }}">{{ $statusText }}</span>
                    </td>

                    <td class="td-id-images">
                      <div class="id-thumbs">
                        {{-- Absher --}}
                        @if($absherUrl)
                          <a href="{{ $absherUrl }}" target="_blank" class="id-thumb" title="@lang('employees::employees.Absher ID Image')" rel="noopener noreferrer">
                            <img src="{{ $absherUrl }}" alt="@lang('employees::employees.Absher ID Image')" loading="lazy" decoding="async" referrerpolicy="no-referrer"
                                 onerror="this.closest('.id-thumb').replaceWith(Object.assign(document.createElement('span'),{className:'id-placeholder',innerText:'@lang('employees::employees.No Absher')'}))">
                          </a>
                        @else
                          <span class="id-placeholder">@lang('employees::employees.No Absher')</span>
                        @endif

                        {{-- Tawakkalna --}}
                        @if($tawakUrl)
                          <a href="{{ $tawakUrl }}" target="_blank" class="id-thumb" title="@lang('employees::employees.Tawakkalna ID Image')" rel="noopener noreferrer">
                            <img src="{{ $tawakUrl }}" alt="@lang('employees::employees.Tawakkalna ID Image')" loading="lazy" decoding="async" referrerpolicy="no-referrer"
                                 onerror="this.closest('.id-thumb').replaceWith(Object.assign(document.createElement('span'),{className:'id-placeholder',innerText:'@lang('employees::employees.No Tawakkalna')'}))">
                          </a>
                        @else
                          <span class="id-placeholder">@lang('employees::employees.No Tawakkalna')</span>
                        @endif
                      </div>
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

@includeIf('documents::_list', ['employee' => $item, 'documents' => $item->documents])
@endsection

@push('styles')
<style>
  :root {
    --avatar-size: 72px;
    /* ID thumbnails */
    --id-thumb-w: 128px;
    --id-thumb-h: 80px;
    --id-col-w: 280px;
  }

  .card-header hr { opacity: .15; }
  dl dt { color: #6c757d; } /* muted */
  .employee-avatar { border-radius: .75rem !important; }

  /* ID images column */
  th.th-id-images { width: var(--id-col-w); }
  td.td-id-images > .id-thumbs { display: flex; flex-wrap: wrap; gap: .5rem; align-items: center; }
  .id-thumb {
    inline-size: var(--id-thumb-w);
    block-size: var(--id-thumb-h);
    display: inline-flex; align-items: center; justify-content: center;
    background: #fff; border: 1px solid rgba(0,0,0,.1);
    border-radius: .5rem; overflow: hidden;
  }
  .id-thumb img {
    inline-size: 100%; block-size: 100%; object-fit: contain; display: block;
    transition: transform .15s ease, box-shadow .15s ease;
  }
  .id-thumb:hover img { transform: translateY(-2px) scale(1.02); box-shadow: 0 .25rem .75rem rgba(0,0,0,.08); }
  .id-placeholder {
    min-inline-size: var(--id-thumb-w); block-size: var(--id-thumb-h);
    display: inline-flex; align-items: center; justify-content: center;
    border: 1px dashed rgba(0,0,0,.2); border-radius: .5rem;
    background: #f8f9fa; color: #6c757d; font-size: .75rem; padding: .25rem .5rem;
  }

  /* Thumbnail inside the identity card above */
  .card .id-thumb.d-inline-flex { inline-size: var(--id-thumb-w); block-size: var(--id-thumb-h); }

  /* Responsive */
  @media (max-width: 576px) {
    :root { --id-thumb-w: 104px; --id-thumb-h: 65px; --id-col-w: 240px; }
  }
</style>
@endpush

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Match avatar size to brand/logo height for a tighter visual rhythm
    const brandImg = document.querySelector('.navbar-brand img, header .navbar img, .app-logo img');
    function applySize() {
      if (!brandImg) return;
      const h = Math.round(brandImg.getBoundingClientRect().height || brandImg.naturalHeight || 72);
      if (h && h > 0) document.documentElement.style.setProperty('--avatar-size', h + 'px');
    }
    applySize();
    brandImg?.addEventListener('load', applySize, { once: true });

    // Photo fallback
    const img = document.querySelector('img.employee-avatar');
    const fallback = document.getElementById('avatar-fallback');
    img?.addEventListener('error', () => { img.classList.add('d-none'); fallback?.classList.remove('d-none'); });

    // Copy-to-clipboard for Employer IDs
    document.querySelectorAll('.js-copy').forEach(btn => {
      btn.addEventListener('click', async () => {
        const target = document.querySelector(btn.getAttribute('data-target'));
        if (!target) return;
        try {
          await navigator.clipboard.writeText(target.textContent.trim());
          btn.classList.remove('btn-outline-secondary');
          btn.classList.add('btn-success');
          btn.innerHTML = '<i class="bi bi-check2"></i>';
          setTimeout(() => {
            btn.classList.add('btn-outline-secondary');
            btn.classList.remove('btn-success');
            btn.innerHTML = '<i class="bi bi-clipboard" aria-hidden="true"></i>';
          }, 1200);
        } catch (e) {
          // Fallback: select + copy
          const r = document.createRange();
          r.selectNodeContents(target);
          const sel = window.getSelection();
          sel.removeAllRanges();
          sel.addRange(r);
          document.execCommand('copy');
          sel.removeAllRanges();
        }
      });
    });
  });
</script>
@endpush
@endsection
