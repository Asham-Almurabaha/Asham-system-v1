@extends('layouts.master')
@php use Illuminate\Support\Str; @endphp

@section('content')
<div class="pagetitle">
  <h1>{{ __('تفاصيل السجل') }} #{{ $log->id }}</h1>
  <ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('activity-logs.index') }}">{{ __('سجل النشاط') }}</a></li>
    <li class="breadcrumb-item active">#{{ $log->id }}</li>
  </ul>
</div>

<section class="section">
  <div class="row">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">{{ __('الملخص') }}</h5>
          <dl class="row mb-0">
            <dt class="col-sm-3">{{ __('التاريخ') }}</dt>
            <dd class="col-sm-9">{{ $log->created_at }}</dd>

            <dt class="col-sm-3">{{ __('المستخدم') }}</dt>
            <dd class="col-sm-9">{{ optional($log->causer)->name ?? 'system' }}</dd>

            <dt class="col-sm-3">{{ __('العملية') }}</dt>
            <dd class="col-sm-9"><span class="badge bg-secondary">{{ $log->operation_type }}</span></dd>

            <dt class="col-sm-3">{{ __('الموضوع') }}</dt>
            <dd class="col-sm-9">
              @if($log->subject_type)
                {{ class_basename($log->subject_type) }}@if($log->subject_id)#{{ $log->subject_id }}@endif
              @endif
            </dd>

            @if($log->description)
              <dt class="col-sm-3">{{ __('الوصف') }}</dt>
              <dd class="col-sm-9">{{ $log->description }}</dd>
            @endif
          </dl>

          @php($changes = $log->changes)

          @if($log->operation_type === 'updated' && $changes)
            <h6 class="mt-4">{{ __('التغييرات') }}</h6>
            <div class="table-responsive">
              <table class="table table-sm align-middle">
                <thead>
                  <tr>
                    <th>{{ __('الحقل') }}</th>
                    <th>{{ __('من') }}</th>
                    <th>{{ __('إلى') }}</th>
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
            <form method="POST" action="{{ route('activity-logs.revert', $log) }}" onsubmit="return confirm('{{ __('هل أنت متأكد من إعادة هذه التغييرات؟') }}')">
              @csrf
              <button type="submit" class="btn btn-outline-danger">{{ __('إرجاع التعديلات إلى السابق') }}</button>
            </form>
          @elseif($log->operation_type === 'created' && $log->value_after)
            <h6 class="mt-4">{{ __('الخصائص عند الإنشاء') }}</h6>
            <pre class="mb-0" style="white-space: pre-wrap; word-wrap: break-word;">{{ json_encode($log->value_after, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre>
          @elseif($log->operation_type === 'deleted' && $log->value_before)
            <h6 class="mt-4">{{ __('تم حذف السجل') }}</h6>
            <pre class="mb-0" style="white-space: pre-wrap; word-wrap: break-word;">{{ json_encode($log->value_before, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre>
          @else
            @if($log->properties)
              <h6 class="mt-4">{{ __('تفاصيل') }}</h6>
              <pre class="mb-0" style="white-space: pre-wrap; word-wrap: break-word;">{{ json_encode($log->properties, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre>
            @endif
          @endif
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">{{ __('معلومات الطلب') }}</h5>
          <dl class="row mb-0">
            <dt class="col-sm-4">IP</dt>
            <dd class="col-sm-8">{{ $log->ip }}</dd>
            <dt class="col-sm-4">{{ __('الطريقة') }}</dt>
            <dd class="col-sm-8">{{ $log->method }}</dd>
            <dt class="col-sm-4">{{ __('المسار') }}</dt>
            <dd class="col-sm-8">{{ $log->route ?? Str::limit($log->url, 80) }}</dd>
            <dt class="col-sm-4">{{ __('الكود') }}</dt>
            <dd class="col-sm-8">{{ $log->status }}</dd>
          </dl>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

