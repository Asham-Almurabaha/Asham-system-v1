@if($contracts->count())
<div class="card shadow-sm border-0 mb-3" dir="{{ app()->getLocale()=='ar'?'rtl':'ltr' }}">
    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between">
        <h6 class="mb-0">@lang('app.Contracts')</h6>
        <x-btn href="{{ route('hr.employees.contracts.create', $employee) }}" size="sm" variant="success" icon="bi bi-plus-circle">
            @lang('app.New Contract')
        </x-btn>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>@lang('app.Start')</th>
                    <th>@lang('app.End')</th>
                    <th>@lang('app.Status')</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contracts as $c)
                    <tr>
                        <td>{{ $c->id }}</td>
                        <td>{{ $c->start_at }}</td>
                        <td>{{ $c->end_at }}</td>
                        <td>{{ $c->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
