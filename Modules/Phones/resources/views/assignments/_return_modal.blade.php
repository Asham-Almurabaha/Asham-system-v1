@if($phone->currentAssignment)
<div class="modal fade" id="returnModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">@lang('phones::assignments.Return')</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="{{ route('phones.assignments.return', [$phone, $phone->currentAssignment]) }}" class="row g-3">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">@lang('phones::assignments.Returned At')</label>
            <input type="datetime-local" name="returned_at" class="form-control @error('returned_at') is-invalid @enderror">
            @error('returned_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="mb-3">
            <label class="form-label">@lang('phones::assignments.Condition On Return')</label>
            <select name="condition_on_return" class="form-select @error('condition_on_return') is-invalid @enderror">
              @foreach(\Modules\Phones\Entities\PhoneCondition::cases() as $c)
                <option value="{{ $c->value }}">{{ $c->value }}</option>
              @endforeach
            </select>
            @error('condition_on_return')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="mb-3">
            <label class="form-label">@lang('phones::assignments.Notes')</label>
            <input type="text" name="notes" class="form-control @error('notes') is-invalid @enderror">
            @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>
        <div class="modal-footer">
          <x-btn type="submit" variant="outline-warning" icon="bi bi-check2">@lang('phones::assignments.Return')</x-btn>
        </div>
      </form>
    </div>
  </div>
</div>
@endif
