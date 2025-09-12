<div class="row g-3">
  <div class="col-md-6">
    <label class="form-label">@lang('cars::cars.Plate Number')</label>
    <input type="text" name="plate_number" value="{{ old('plate_number', $car->plate_number) }}" class="form-control @error('plate_number') is-invalid @enderror" required>
    @error('plate_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-6">
    <label class="form-label">@lang('cars::cars.VIN')</label>
    <input type="text" name="vin" value="{{ old('vin', $car->vin) }}" class="form-control @error('vin') is-invalid @enderror">
    @error('vin')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">@lang('cars::cars.Year')</label>
    <input type="number" name="year" value="{{ old('year', $car->year) }}" class="form-control @error('year') is-invalid @enderror" required>
    @error('year')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">@lang('cars::cars.Brand')</label>
    <input type="text" name="brand" value="{{ old('brand', $car->brand) }}" class="form-control @error('brand') is-invalid @enderror" required>
    @error('brand')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">@lang('cars::cars.Model')</label>
    <input type="text" name="model" value="{{ old('model', $car->model) }}" class="form-control @error('model') is-invalid @enderror" required>
    @error('model')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">@lang('cars::cars.Color')</label>
    <input type="text" name="color" value="{{ old('color', $car->color) }}" class="form-control @error('color') is-invalid @enderror">
    @error('color')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">@lang('cars::cars.Status')</label>
    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
      @foreach(\Modules\Cars\Entities\CarStatus::cases() as $status)
        <option value="{{ $status->value }}" @selected(old('status', $car->status?->value) == $status->value)>{{ $status->value }}</option>
      @endforeach
    </select>
    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">@lang('cars::cars.Branch')</label>
    <select name="branch_id" class="form-select @error('branch_id') is-invalid @enderror" required>
      @foreach($branches as $branch)
        <option value="{{ $branch->id }}" @selected(old('branch_id', $car->branch_id) == $branch->id)>{{ $branch->name }}</option>
      @endforeach
    </select>
    @error('branch_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">@lang('cars::cars.Purchase Date')</label>
    <input type="date" name="purchase_date" value="{{ old('purchase_date', optional($car->purchase_date)->format('Y-m-d')) }}" class="form-control @error('purchase_date') is-invalid @enderror">
    @error('purchase_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">@lang('cars::cars.Cost')</label>
    <input type="number" step="0.01" name="cost" value="{{ old('cost', $car->cost) }}" class="form-control @error('cost') is-invalid @enderror">
    @error('cost')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-12">
    <label class="form-label">@lang('cars::cars.Notes')</label>
    <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="3">{{ old('notes', $car->notes) }}</textarea>
    @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
</div>
