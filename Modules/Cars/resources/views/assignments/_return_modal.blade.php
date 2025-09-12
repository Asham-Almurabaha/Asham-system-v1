@if($car->currentAssignment)
<div class="modal fade" id="returnModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">@lang('cars::assignments.Return')</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="{{ route('cars.assignments.return', [$car, $car->currentAssignment]) }}" class="row g-3">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">@lang('cars::assignments.Returned At')</label>
            <input type="datetime-local" name="returned_at" class="form-control @error('returned_at') is-invalid @enderror">
            @error('returned_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="mb-3">
            <label class="form-label">@lang('cars::assignments.Condition On Return')</label>
            <select name="condition_on_return" class="form-select @error('condition_on_return') is-invalid @enderror">
              @foreach(\Modules\Cars\Entities\CarCondition::cases() as $c)
                <option value="{{ $c->value }}">{{ $c->value }}</option>
              @endforeach
            </select>
            @error('condition_on_return')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="mb-3">
            <label class="form-label">@lang('cars::assignments.Notes')</label>
            <input type="text" name="notes" class="form-control @error('notes') is-invalid @enderror">
            @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>
        <div class="modal-footer">
          <x-btn type="submit" variant="outline-warning" icon="bi bi-check2">@lang('cars::assignments.Return')</x-btn>
        </div>
      </form>
    </div>
  </div>
</div>
@endif
