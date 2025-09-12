<div class="row g-3">
  <div class="col-md-6">
    <label class="form-label">@lang('motorcycles::motorcycles.Plate Number')</label>
    <input type="text" name="plate_number" value="{{ old('plate_number', $motorcycle->plate_number) }}" class="form-control @error('plate_number') is-invalid @enderror" required>
    @error('plate_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-6">
    <label class="form-label">@lang('motorcycles::motorcycles.Chassis Number')</label>
    <input type="text" name="chassis_number" value="{{ old('chassis_number', $motorcycle->chassis_number) }}" class="form-control @error('chassis_number') is-invalid @enderror">
    @error('chassis_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">@lang('motorcycles::motorcycles.Year')</label>
    <input type="number" name="year" value="{{ old('year', $motorcycle->year) }}" class="form-control @error('year') is-invalid @enderror" required>
    @error('year')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">@lang('motorcycles::motorcycles.Brand')</label>
    <input type="text" name="brand" value="{{ old('brand', $motorcycle->brand) }}" class="form-control @error('brand') is-invalid @enderror" required>
    @error('brand')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">@lang('motorcycles::motorcycles.Model')</label>
    <input type="text" name="model" value="{{ old('model', $motorcycle->model) }}" class="form-control @error('model') is-invalid @enderror" required>
    @error('model')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">@lang('motorcycles::motorcycles.Color')</label>
    <input type="text" name="color" value="{{ old('color', $motorcycle->color) }}" class="form-control @error('color') is-invalid @enderror">
    @error('color')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">@lang('motorcycles::motorcycles.Status')</label>
    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
      @foreach(\Modules\Motorcycles\Entities\MotorcycleStatus::cases() as $status)
        <option value="{{ $status->value }}" @selected(old('status', $motorcycle->status?->value) == $status->value)>{{ $status->value }}</option>
      @endforeach
    </select>
    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">@lang('motorcycles::motorcycles.Branch')</label>
    <select name="branch_id" class="form-select @error('branch_id') is-invalid @enderror" required>
      @foreach($branches as $branch)
        <option value="{{ $branch->id }}" @selected(old('branch_id', $motorcycle->branch_id) == $branch->id)>{{ $branch->name }}</option>
      @endforeach
    </select>
    @error('branch_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">@lang('motorcycles::motorcycles.Purchase Date')</label>
    <input type="date" name="purchase_date" value="{{ old('purchase_date', optional($motorcycle->purchase_date)->format('Y-m-d')) }}" class="form-control @error('purchase_date') is-invalid @enderror">
    @error('purchase_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">@lang('motorcycles::motorcycles.Cost')</label>
    <input type="number" step="0.01" name="cost" value="{{ old('cost', $motorcycle->cost) }}" class="form-control @error('cost') is-invalid @enderror">
    @error('cost')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-12">
    <label class="form-label">@lang('motorcycles::motorcycles.Notes')</label>
    <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="3">{{ old('notes', $motorcycle->notes) }}</textarea>
    @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
</div>
