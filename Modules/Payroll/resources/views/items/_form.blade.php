@if(View::exists('layouts.master'))
<form action="{{ route('hr.payroll.items.upsert', $run) }}" method="POST" class="row g-2">
    @csrf
    <div class="col-3"><input type="number" name="employee_id" class="form-control" placeholder="employee_id" required></div>
    <div class="col-2"><input type="number" step="0.01" name="basic" class="form-control" placeholder="basic" required></div>
    <div class="col-2"><input type="number" step="0.01" name="net" class="form-control" placeholder="net" required></div>
    <div class="col-2"><input type="number" step="0.01" name="overtime_amount" class="form-control" placeholder="OT"></div>
    <div class="col-3"><x-btn type="submit" variant="primary">@lang('app.Save')</x-btn></div>
</form>
@else
<form action="{{ route('hr.payroll.items.upsert', $run) }}" method="POST">@csrf<input name="employee_id"/><button>@lang('app.Save')</button></form>
@endif
