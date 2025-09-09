@extends('layouts.master')
@section('title', __('auditlogs::audit.Audit Logs'))

@section('content')
<div class="container py-3" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item active" aria-current="page">@lang('auditlogs::audit.Audit Logs')</li>
    </ol>
  </nav>

  <div class="d-flex align-items-center justify-content-between mb-3">
    <div>
      <h4 class="mb-0">@lang('auditlogs::audit.Audit Logs')</h4>
      <small class="text-muted">@lang('auditlogs::audit.History Description')</small>
    </div>
  </div>

  <div class="card shadow-sm">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>@lang('auditlogs::audit.Table')</th>
            <th>@lang('auditlogs::audit.Record')</th>
            <th>@lang('auditlogs::audit.Action')</th>
            <th>@lang('auditlogs::audit.User')</th>
            <th>@lang('auditlogs::audit.At')</th>
            <th class="text-end">@lang('auditlogs::audit.Actions')</th>
          </tr>
        </thead>
        <tbody>
          @forelse($logs as $log)
            <tr>
              <td>{{ $log->id }}</td>
              <td>{{ $log->table_name }}</td>
              <td>{{ $log->record_id }}</td>
              <td>
                @php
                  $badge = ['INSERT' => 'success', 'UPDATE' => 'warning', 'DELETE' => 'danger'][$log->action] ?? 'secondary';
                @endphp
                <span class="badge bg-{{ $badge }}">{{ $log->action }}</span>
              </td>
              <td>{{ optional($log->user)->name ?? $log->performed_by }}</td>
              <td>
                {{ $log->performed_at?->format('Y-m-d H:i') }}
                <span class="text-muted">— {{ $log->performed_at?->diffForHumans() }}</span>
              </td>
              <td class="text-end">
                <x-btn href="{{ route('audit-logs.show', $log) }}" size="sm" variant="outline-secondary" icon="bi bi-eye">@lang('auditlogs::audit.View')</x-btn>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center text-muted">@lang('auditlogs::audit.No logs found')</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-body">{{ $logs->links() }}</div>
  </div>
</div>
@endsection
