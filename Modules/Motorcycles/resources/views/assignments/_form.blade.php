@if(!$motorcycle->currentAssignment)
  <form method="POST" action="{{ route('motorcycles.assignments.store',$motorcycle) }}" class="mb-3">
    @csrf
    <div class="row g-2 align-items-end">
      <div class="col">
        <label class="form-label">@lang('motorcycles::assignments.Employee ID')</label>
        <input type="number" name="employee_id" class="form-control" />
      </div>
      <div class="col">
        <label class="form-label">@lang('motorcycles::assignments.Assigned At')</label>
        <input type="datetime-local" name="assigned_at" class="form-control" />
      </div>
      <div class="col">
        <label class="form-label">@lang('motorcycles::assignments.Condition')</label>
        <select name="condition_on_assign" class="form-select">
          @foreach(\Modules\Motorcycles\Entities\MotorcycleCondition::cases() as $c)
            <option value="{{ $c->value }}">{{ $c->value }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-auto">
        <x-btn type="submit" variant="primary">@lang('motorcycles::assignments.Assign')</x-btn>
      </div>
    </div>
  </form>
@else
  <form method="POST" action="{{ route('motorcycles.assignments.return',[$motorcycle,$motorcycle->currentAssignment]) }}" class="mb-3">
    @csrf
    <div class="row g-2 align-items-end">
      <div class="col">
        <label class="form-label">@lang('motorcycles::assignments.Returned At')</label>
        <input type="datetime-local" name="returned_at" class="form-control" />
      </div>
      <div class="col">
        <label class="form-label">@lang('motorcycles::assignments.Condition')</label>
        <select name="condition_on_return" class="form-select">
          @foreach(\Modules\Motorcycles\Entities\MotorcycleCondition::cases() as $c)
            <option value="{{ $c->value }}">{{ $c->value }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-auto">
        <x-btn type="submit" variant="danger">@lang('motorcycles::assignments.Return')</x-btn>
      </div>
    </div>
  </form>
@endif
