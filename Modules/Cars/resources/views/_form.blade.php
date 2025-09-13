<div class="row g-3">
  <div class="col-md-6">
    <label class="form-label">@lang('cars::cars.Sequence Number')</label>
    <input type="text" name="sequence_number" value="{{ old('sequence_number', $car->sequence_number) }}" class="form-control @error('sequence_number') is-invalid @enderror">
    @error('sequence_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
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
    <select name="car_year_id" class="form-select @error('car_year_id') is-invalid @enderror" required>
      @foreach($years as $year)
        <option value="{{ $year->id }}" @selected(old('car_year_id', $car->car_year_id) == $year->id)>{{ $year->year }}</option>
      @endforeach
    </select>
    @error('car_year_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">@lang('cars::cars.Type')</label>
    <select name="car_type_id" class="form-select @error('car_type_id') is-invalid @enderror" required>
      @foreach($types as $type)
        <option value="{{ $type->id }}" @selected(old('car_type_id', $car->car_type_id) == $type->id)>{{ $type->{app()->getLocale() === 'ar' ? 'name_ar' : 'name_en'} }}</option>
      @endforeach
    </select>
    @error('car_type_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">@lang('cars::cars.Brand')</label>
    <select name="car_brand_id" class="form-select @error('car_brand_id') is-invalid @enderror" required>
      @foreach($brands as $brand)
        <option value="{{ $brand->id }}" @selected(old('car_brand_id', $car->car_brand_id) == $brand->id)>{{ $brand->{app()->getLocale() === 'ar' ? 'name_ar' : 'name_en'} }}</option>
      @endforeach
    </select>
    @error('car_brand_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">@lang('cars::cars.Model')</label>
    <select name="car_model_id" class="form-select @error('car_model_id') is-invalid @enderror" required>
      @foreach($models as $model)
        <option value="{{ $model->id }}" @selected(old('car_model_id', $car->car_model_id) == $model->id)>{{ $model->{app()->getLocale() === 'ar' ? 'name_ar' : 'name_en'} }}</option>
      @endforeach
    </select>
    @error('car_model_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">@lang('cars::cars.Color')</label>
    <select name="car_color_id" class="form-select @error('car_color_id') is-invalid @enderror">
      @foreach($colors as $color)
        <option value="{{ $color->id }}" @selected(old('car_color_id', $car->car_color_id) == $color->id)>{{ $color->{app()->getLocale() === 'ar' ? 'name_ar' : 'name_en'} }}</option>
      @endforeach
    </select>
    @error('car_color_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">@lang('cars::cars.Status')</label>
    <select name="car_status_id" class="form-select @error('car_status_id') is-invalid @enderror" required>
      @foreach($statuses as $status)
        <option value="{{ $status->id }}" @selected(old('car_status_id', $car->car_status_id) == $status->id)>{{ $status->{app()->getLocale() === 'ar' ? 'name_ar' : 'name_en'} }}</option>
      @endforeach
    </select>
    @error('car_status_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
