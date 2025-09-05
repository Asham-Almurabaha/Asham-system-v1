@extends('layouts.master')
@php use Illuminate\Support\Str; @endphp

@section('content')
<div class="pagetitle">
  <h1>{{ __('سجل النشاط') }}</h1>
  <p class="text-muted mb-0">{{ __('عرض أوضح: التاريخ، المستخدم، والتغييرات من → إلى') }}</p>
  <hr>
</div>

<section class="section">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">{{ __('أحدث الأنشطة') }}</h5>

      <div class="table-responsive">
        <table class="table table-striped align-middle">
          <thead>
            <tr>
              <th>#</th>
              <th>{{ __('التاريخ') }}</th>
              <th>{{ __('المستخدم') }}</th>
              <th>{{ __('العملية') }}</th>
              <th>{{ __('الموضوع') }}</th>
              <th style="width:40%">{{ __('التغييرات (من → إلى)') }}</th>
              <th class="text-end">{{ __('التحكم') }}</th>
            </tr>
          </thead>
          <tbody>
            @forelse($logs as $log)
              <tr>
                <td>{{ $log->id }}</td>
                <td><small>{{ $log->created_at }}</small></td>
                <td>{{ optional($log->causer)->name ?? 'system' }}</td>
                <td><span class="badge bg-secondary">{{ $log->operation_type }}</span></td>
                <td>
                  @if($log->subject_type)
                    <small>{{ class_basename($log->subject_type) }}@if($log->subject_id)#{{ $log->subject_id }}@endif</small>
                  @endif
                </td>
                <td>
                  @php($changes = $log->changes)
                  @if($log->operation_type === 'updated' && $changes)
                    <ul class="mb-0 small">
                      @foreach($changes as $k => $diff)
                        @php($from = $diff['from'])
                        @php($to = $diff['to'])
                        <li><code>{{ $k }}</code>: <span class="text-danger">{{ Str::limit((string)($from===null?'∅':$from), 20) }}</span> → <span class="text-success">{{ Str::limit((string)($to===null?'∅':$to), 20) }}</span></li>
                      @endforeach
                    </ul>
                  @elseif($log->operation_type === 'created' && $log->value_after)
                    <small class="text-muted">{{ __('سجل إنشاء') }}</small>
                  @elseif($log->operation_type === 'deleted')
                    <small class="text-muted">{{ __('سجل حذف') }}</small>
                  @else
                    <small class="text-muted">{{ $log->description }}</small>
                  @endif
                </td>
                <td class="text-end">
                  <a class="btn btn-sm btn-outline-primary" href="{{ route('activity-logs.show', $log) }}">{{ __('عرض') }}</a>
                  @if($log->operation_type === 'updated')
                    <form class="d-inline" method="POST" action="{{ route('activity-logs.revert', $log) }}" onsubmit="return confirm('{{ __('هل أنت متأكد من إعادة التعديلات؟') }}')">
                      @csrf
                      <button type="submit" class="btn btn-sm btn-outline-danger">{{ __('إرجاع') }}</button>
                    </form>
                  @endif
                </td>
              </tr>
              
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
