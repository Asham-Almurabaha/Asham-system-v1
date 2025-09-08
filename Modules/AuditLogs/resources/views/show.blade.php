@extends('layouts.master')
@section('title', __('auditlogs::audit.Audit Logs'))

@section('content')
<div class="container py-3" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="{{ route('audit-logs.index') }}">@lang('auditlogs::audit.Audit Logs')</a></li>
      <li class="breadcrumb-item active" aria-current="page">#{{ $auditLog->id }}</li>
    </ol>
  </nav>

  <div class="d-flex align-items-center justify-content-between mb-3">
    <div>
      <h4 class="mb-0">@lang('auditlogs::audit.Log Details')</h4>
      <small class="text-muted">@lang('auditlogs::audit.Entry ID'): {{ $auditLog->id }}</small>
    </div>
    <div class="d-flex gap-2">
      @if(in_array($auditLog->action, ['DELETE', 'UPDATE']))
        <form action="{{ route('audit-logs.revert', $auditLog) }}" method="POST" class="d-inline">
          @csrf
          <x-btn type="submit" variant="outline-danger" icon="bi bi-arrow-counterclockwise">@lang('auditlogs::audit.Revert')</x-btn>
        </form>
      @endif
      <x-btn href="{{ route('audit-logs.index') }}" variant="outline-secondary" icon="bi bi-arrow-right-circle">@lang('auditlogs::audit.Back')</x-btn>
    </div>
  </div>

  <div class="row g-3">
    <div class="col-lg-5">
      <div class="card shadow-sm h-100">
        <div class="card-body mt-2">
          <h6 class="mb-3">@lang('auditlogs::audit.Summary')</h6>
          <div class="table-responsive">
            <table class="table table-sm align-middle mb-0">
              <tbody>
                <tr>
                  <th style="width:200px">@lang('auditlogs::audit.Table')</th>
                  <td class="fw-medium">{{ $auditLog->table_name }}</td>
                </tr>
                <tr>
                  <th>@lang('auditlogs::audit.Record')</th>
                  <td class="fw-medium">{{ $auditLog->record_id }}</td>
                </tr>
                <tr>
                  <th>@lang('auditlogs::audit.Action')</th>
                  <td>
                    @php($badge = ['INSERT' => 'success', 'UPDATE' => 'warning', 'DELETE' => 'danger'][$auditLog->action] ?? 'secondary')
                    <span class="badge bg-{{ $badge }}">{{ $auditLog->action }}</span>
                  </td>
                </tr>
                <tr>
                  <th>@lang('auditlogs::audit.User')</th>
                  <td class="fw-medium">{{ optional($auditLog->user)->name ?? $auditLog->performed_by }}</td>
                </tr>
                <tr>
                  <th>@lang('auditlogs::audit.At')</th>
                  <td>
                    {{ $auditLog->performed_at?->format('Y-m-d H:i') }}
                    <span class="text-muted">— {{ $auditLog->performed_at?->diffForHumans() }}</span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-7">
      <div class="card shadow-sm h-100">
        <div class="card-body mt-2">
          <h6 class="mb-3">@lang('auditlogs::audit.Changes')</h6>
          <div class="row g-3">
            <div class="col-md-6">
              <div>
                <div class="text-muted small mb-1">@lang('auditlogs::audit.Old Values')</div>
                <pre class="bg-light border rounded p-2 small mb-0">@json($auditLog->old_values, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)</pre>
              </div>
            </div>
            <div class="col-md-6">
              <div>
                <div class="text-muted small mb-1">@lang('auditlogs::audit.New Values')</div>
                <pre class="bg-light border rounded p-2 small mb-0">@json($auditLog->new_values, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)</pre>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
