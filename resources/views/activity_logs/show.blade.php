@extends('layouts.master')
@php use Illuminate\Support\Str; @endphp

@section('content')
<div class="pagetitle d-flex justify-content-between align-items-center">
  <div>
    <h1>{{ __('activitylogs.Log Details') }} #{{ $log->id }}</h1>
    <ul class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('activity-logs.index') }}">{{ __('activitylogs.Activity Log') }}</a></li>
      <li class="breadcrumb-item active">#{{ $log->id }}</li>
    </ul>
  </div>
  @if(in_array($log->operation_type, ['updated', 'created', 'deleted']))
    <form method="POST" action="{{ route('activity-logs.revert', $log) }}" onsubmit="return confirm('{{ __('activitylogs.Are you sure to revert this operation?') }}')">
      @csrf
      <button type="submit" class="btn btn-danger">{{ __('activitylogs.Revert') }}</button>
    </form>
  @endif
</div>

<section class="section">
  <div class="row">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">{{ __('activitylogs.Summary') }}</h5>
          <dl class="row mb-0">
            <dt class="col-sm-3">{{ __('activitylogs.Date') }}</dt>
            <dd class="col-sm-9">{{ $log->created_at }}</dd>

            <dt class="col-sm-3">{{ __('activitylogs.User') }}</dt>
            <dd class="col-sm-9">{{ optional($log->causer)->name ?? 'system' }}</dd>

            <dt class="col-sm-3">{{ __('activitylogs.Operation') }}</dt>
            <dd class="col-sm-9"><span class="badge bg-secondary">{{ $log->operation_type }}</span></dd>

            <dt class="col-sm-3">{{ __('activitylogs.Subject') }}</dt>
            <dd class="col-sm-9">
              @if($log->subject_type)
                {{ class_basename($log->subject_type) }}@if($log->subject_id)#{{ $log->subject_id }}@endif
              @endif
            </dd>

            @if($log->description)
              <dt class="col-sm-3">{{ __('activitylogs.Description') }}</dt>
              <dd class="col-sm-9">{{ $log->description }}</dd>
            @endif
          </dl>

          @php($changes = $log->changes)

          @if($log->operation_type === 'updated' && $changes)
            <h6 class="mt-4">{{ __('activitylogs.Changes') }}</h6>
            <div class="table-responsive">
              <table class="table table-sm align-middle">
                <thead>
                  <tr>
                    <th>{{ __('activitylogs.Field') }}</th>
                    <th>{{ __('activitylogs.From') }}</th>
                    <th>{{ __('activitylogs.To') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($changes as $k => $diff)
                    @php($from = $diff['from'])
                    @php($to = $diff['to'])
                    <tr>
                      <td><code>{{ $k }}</code></td>
                      <td class="text-danger">{{ is_null($from) ? '∅' : (is_scalar($from) ? (string)$from : json_encode($from, JSON_UNESCAPED_UNICODE)) }}</td>
                      <td class="text-success">{{ is_null($to) ? '∅' : (is_scalar($to) ? (string)$to : json_encode($to, JSON_UNESCAPED_UNICODE)) }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @elseif($log->operation_type === 'created' && $log->value_after)
            <h6 class="mt-4">{{ __('activitylogs.Attributes at creation') }}</h6>
            <pre class="mb-0" style="white-space: pre-wrap; word-wrap: break-word;">{{ json_encode($log->value_after, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre>
          @elseif($log->operation_type === 'deleted' && $log->value_before)
            <h6 class="mt-4">{{ __('activitylogs.Record deleted') }}</h6>
            <pre class="mb-0" style="white-space: pre-wrap; word-wrap: break-word;">{{ json_encode($log->value_before, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre>
          @else
            @if($log->properties)
              <h6 class="mt-4">{{ __('activitylogs.Details') }}</h6>
              <pre class="mb-0" style="white-space: pre-wrap; word-wrap: break-word;">{{ json_encode($log->properties, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre>
            @endif
          @endif
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">{{ __('activitylogs.Request Info') }}</h5>
          <dl class="row mb-0">
            <dt class="col-sm-4">IP</dt>
            <dd class="col-sm-8">{{ $log->ip }}</dd>
            <dt class="col-sm-4">{{ __('activitylogs.Method') }}</dt>
            <dd class="col-sm-8">{{ $log->method }}</dd>
            <dt class="col-sm-4">{{ __('activitylogs.Path') }}</dt>
            <dd class="col-sm-8">{{ $log->route ?? Str::limit($log->url, 80) }}</dd>
            <dt class="col-sm-4">{{ __('activitylogs.Status Code') }}</dt>
            <dd class="col-sm-8">{{ $log->status }}</dd>
          </dl>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

