@extends('layouts.master')
@php use Illuminate\Support\Str; @endphp

@section('content')
<div class="pagetitle">
  <h1>{{ __('Activity Logs') }}</h1>
</div>

<section class="section">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">{{ __('Recent Activity') }}</h5>

      <div class="table-responsive">
        <table class="table table-striped align-middle">
          <thead>
            <tr>
              <th>#</th>
              <th>{{ __('Time') }}</th>
              <th>{{ __('User') }}</th>
              <th>{{ __('Event') }}</th>
              <th>{{ __('Subject') }}</th>
              <th>{{ __('Description') }}</th>
              <th>{{ __('Method') }}</th>
              <th>{{ __('Route/URL') }}</th>
              <th>{{ __('IP') }}</th>
            </tr>
          </thead>
          <tbody>
            @forelse($logs as $log)
              <tr>
                <td>{{ $log->id }}</td>
                <td><small>{{ $log->created_at }}</small></td>
                <td>{{ optional($log->causer)->name ?? 'system' }}</td>
                <td><span class="badge bg-secondary">{{ $log->event }}</span></td>
                <td>
                  @if($log->subject_type)
                    <small>{{ class_basename($log->subject_type) }}@if($log->subject_id)#{{ $log->subject_id }}@endif</small>
                  @endif
                </td>
                <td>{{ $log->description }}</td>
                <td>{{ $log->method }}</td>
                <td>
                  <small>
                    @if($log->route)
                      {{ $log->route }}
                    @elseif($log->url)
                      {{ Str::limit($log->url, 60) }}
                    @endif
                  </small>
                </td>
                <td><small>{{ $log->ip }}</small></td>
              </tr>
              @if($log->properties)
                <tr>
                  <td colspan="9">
                    <pre class="mb-0" style="white-space: pre-wrap; word-wrap: break-word; max-height: 240px; overflow:auto;">{{ json_encode($log->properties, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre>
                  </td>
                </tr>
              @endif
            @empty
              <tr>
                <td colspan="9" class="text-center text-muted">{{ __('No activity yet') }}</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div>
        {{ $logs->links() }}
      </div>
    </div>
  </div>
</section>
@endsection
