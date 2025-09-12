@if(View::exists('layouts.master'))
@extends('layouts.master')
@section('title', __('app.Contracts'))
@section('content')
<div class="container py-3" dir="{{ app()->getLocale()=='ar'?'rtl':'ltr' }}">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="mb-0">@lang('app.Contracts')</h2>
        <x-btn href="{{ route('hr.employees.contracts.create', $employee) }}" size="sm" variant="success" icon="bi bi-plus-circle">
            @lang('app.New Contract')
        </x-btn>
    </div>
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>@lang('app.Start')</th>
                        <th>@lang('app.End')</th>
                        <th>@lang('app.Status')</th>
                        <th class="text-end"></th>
                    </tr>
                </thead>
                <tbody>
                @forelse($contracts as $c)
                    <tr>
                        <td>{{ $c->id }}</td>
                        <td>{{ $c->start_at }}</td>
                        <td>{{ $c->end_at }}</td>
                        <td>{{ $c->status }}</td>
                        <td class="text-end">
                            <x-btn href="{{ route('hr.contracts.destroy', $c) }}" method="DELETE" size="sm" variant="outline-danger" icon="bi bi-trash">
                                @lang('app.Delete')
                            </x-btn>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted">@lang('app.No data')</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@else
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale()=='ar'?'rtl':'ltr' }}">
<body>
<div class="container py-3">
    <h2 class="mb-3">@lang('app.Contracts')</h2>
    <a href="{{ route('hr.employees.contracts.create', $employee) }}">@lang('app.New Contract')</a>
    <table border="1" width="100%" class="mt-3">
        <tr><th>ID</th><th>@lang('app.Start')</th><th>@lang('app.End')</th><th>@lang('app.Status')</th></tr>
        @foreach($contracts as $c)
        <tr>
            <td>{{ $c->id }}</td>
            <td>{{ $c->start_at }}</td>
            <td>{{ $c->end_at }}</td>
            <td>{{ $c->status }}</td>
        </tr>
        @endforeach
    </table>
</div>
</body>
</html>
@endif
