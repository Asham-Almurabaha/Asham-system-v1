<form method="POST" action="{{ route('cars.assignments.store', $car) }}" class="row g-3 mb-4">
  @csrf
  <div class="col-md-4">
    <label class="form-label">@lang('cars::assignments.Employee')</label>
    <input type="number" name="employee_id" class="form-control @error('employee_id') is-invalid @enderror">
    @error('employee_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">@lang('cars::assignments.Assigned At')</label>
    <input type="datetime-local" name="assigned_at" class="form-control @error('assigned_at') is-invalid @enderror">
    @error('assigned_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">@lang('cars::assignments.Condition On Assign')</label>
    <select name="condition_on_assign" class="form-select @error('condition_on_assign') is-invalid @enderror">
      @foreach(\Modules\Cars\Entities\CarCondition::cases() as $c)
        <option value="{{ $c->value }}" @selected(old('condition_on_assign')==$c->value)>{{ $c->value }}</option>
      @endforeach
    </select>
    @error('condition_on_assign')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">@lang('cars::assignments.Notes')</label>
    <input type="text" name="notes" class="form-control @error('notes') is-invalid @enderror">
    @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">@lang('cars::assignments.Document Number')</label>
    <input type="text" name="document_number" class="form-control @error('document_number') is-invalid @enderror">
    @error('document_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-12">
    <x-btn type="submit" variant="primary" icon="bi bi-check2">@lang('cars::assignments.Assign')</x-btn>
  </div>
</form>
