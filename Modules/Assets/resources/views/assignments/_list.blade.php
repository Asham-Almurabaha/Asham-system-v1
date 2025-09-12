@if($assignments->count())
<div class="card shadow-sm border-0 mb-3" dir="{{ app()->getLocale()=='ar'?'rtl':'ltr' }}">
    <div class="card-header bg-white border-0 py-3"><h6 class="mb-0">@lang('app.Assets')</h6></div>
    <div class="table-responsive">
        <table class="table mb-0">
            <tr><th>@lang('app.Employee')</th><th>@lang('app.Assign')</th><th>@lang('app.Return')</th></tr>
            @foreach($assignments as $as)
            <tr>
                <td>{{ $as->employee?->first_name }}</td>
                <td>{{ $as->assigned_at }}</td>
                <td>{{ $as->returned_at }}</td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endif
