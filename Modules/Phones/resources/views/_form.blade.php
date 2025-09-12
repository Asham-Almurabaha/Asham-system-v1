<div class="row g-3">
  <div class="col-md-6">
    <label class="form-label">@lang('phones::phones.IMEI')</label>
    <input type="text" name="imei" value="{{ old('imei', $phone->imei) }}" class="form-control @error('imei') is-invalid @enderror" required>
    @error('imei')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-6">
    <label class="form-label">@lang('phones::phones.Serial Number')</label>
    <input type="text" name="serial_number" value="{{ old('serial_number', $phone->serial_number) }}" class="form-control @error('serial_number') is-invalid @enderror">
    @error('serial_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">@lang('phones::phones.Brand')</label>
    <input type="text" name="brand" value="{{ old('brand', $phone->brand) }}" class="form-control @error('brand') is-invalid @enderror" required>
    @error('brand')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">@lang('phones::phones.Model')</label>
    <input type="text" name="model" value="{{ old('model', $phone->model) }}" class="form-control @error('model') is-invalid @enderror" required>
    @error('model')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">@lang('phones::phones.Color')</label>
    <input type="text" name="color" value="{{ old('color', $phone->color) }}" class="form-control @error('color') is-invalid @enderror">
    @error('color')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">@lang('phones::phones.Line Number')</label>
    <input type="text" name="line_number" value="{{ old('line_number', $phone->line_number) }}" class="form-control @error('line_number') is-invalid @enderror">
    @error('line_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">@lang('phones::phones.Status')</label>
    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
      @foreach(\Modules\Phones\Entities\PhoneStatus::cases() as $status)
        <option value="{{ $status->value }}" @selected(old('status', $phone->status?->value) == $status->value)>{{ $status->value }}</option>
      @endforeach
    </select>
    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">@lang('phones::phones.Branch')</label>
    <select name="branch_id" class="form-select @error('branch_id') is-invalid @enderror" required>
      @foreach($branches as $branch)
        <option value="{{ $branch->id }}" @selected(old('branch_id', $phone->branch_id) == $branch->id)>{{ $branch->name }}</option>
      @endforeach
    </select>
    @error('branch_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">@lang('phones::phones.Purchase Date')</label>
    <input type="date" name="purchase_date" value="{{ old('purchase_date', optional($phone->purchase_date)->format('Y-m-d')) }}" class="form-control @error('purchase_date') is-invalid @enderror">
    @error('purchase_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">@lang('phones::phones.Cost')</label>
    <input type="number" step="0.01" name="cost" value="{{ old('cost', $phone->cost) }}" class="form-control @error('cost') is-invalid @enderror">
    @error('cost')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-12">
    <label class="form-label">@lang('phones::phones.Notes')</label>
    <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="3">{{ old('notes', $phone->notes) }}</textarea>
    @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
</div>
