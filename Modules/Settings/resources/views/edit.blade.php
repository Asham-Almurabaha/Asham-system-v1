@extends('layouts.master')
@section('title', __('settings::setting.Edit Settings'))

@section('content')
<div class="container py-3">
  <div class="row">
    <div class="col-lg-8 mx-auto">
      <div class="card shadow-sm">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h5 class="mb-0">@lang('settings::setting.Edit Settings')</h5>
          <x-btn href="{{ route('settings.index') }}" variant="outline-secondary" size="sm" icon="bi bi-arrow-right-circle">@lang('settings::setting.Back')</x-btn>
        </div>

        <div class="card-body">
          <form method="POST" action="{{ route('settings.update', $setting) }}" enctype="multipart/form-data" class="row g-3">
            @csrf
            @method('PUT')

            {{-- Owner Name --}}
            <div class="col-md-12">
              <label class="form-label">@lang('settings::setting.Owner Name') <span class="text-danger">*</span></label>
              <input type="text"
                     name="owner_name"
                     class="form-control @error('owner_name') is-invalid @enderror"
                     value="{{ old('owner_name',$setting->owner_name) }}"
                     maxlength="50" required>
              @error('owner_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
              <div class="form-text">@lang('settings::setting.Maximum 50 characters')</div>
            </div>

            <div class="col-md-6">
              <label class="form-label">@lang('settings::setting.Name (EN)') <span class="text-danger">*</span></label>
              <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                     value="{{ old('name', $setting->name) }}" maxlength="255" required>
              @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
              <label class="form-label">@lang('settings::setting.Name (AR)') <span class="text-danger">*</span></label>
              <input type="text" name="name_ar" class="form-control @error('name_ar') is-invalid @enderror"
                     value="{{ old('name_ar', $setting->name_ar) }}" maxlength="255" required>
              @error('name_ar') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
              <label class="form-label d-flex justify-content-between">
                <span>@lang('settings::setting.Logo (PNG/JPG/WEBP/SVG)')</span>
                @if(!empty($setting->logo_url))
                  <a href="{{ $setting->logo_url }}" target="_blank" class="small">@lang('settings::setting.View Current')</a>
                @endif
              </label>
              <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror"
                     accept=".png,.jpg,.jpeg,.gif,.webp,.svg">
              @error('logo') <div class="invalid-feedback">{{ $message }}</div> @enderror
              <div class="form-text">@lang('settings::setting.Limit 4MB')</div>

              @if(!empty($setting->logo_url))
                <div class="form-check mt-2">
                  <input class="form-check-input" type="checkbox" value="1" id="remove_logo" name="remove_logo">
                  <label class="form-check-label" for="remove_logo">@lang('settings::setting.Delete current logo')</label>
                </div>
                <div class="mt-2">
                  <img src="{{ $setting->logo_url }}" alt="@lang('settings::setting.Logo')" class="img-fluid rounded border" style="max-height:64px">
                </div>
              @endif
            </div>

            <div class="col-md-6">
              <label class="form-label d-flex justify-content-between">
                <span>@lang('settings::setting.Favicon (ICO/PNG/JPG/WEBP/SVG)')</span>
                @if(!empty($setting->favicon_url))
                  <a href="{{ $setting->favicon_url }}" target="_blank" class="small">@lang('settings::setting.View Current')</a>
                @endif
              </label>
              <input type="file" name="favicon" class="form-control @error('favicon') is-invalid @enderror"
                     accept=".ico,.png,.jpg,.jpeg,.gif,.webp,.svg">
              @error('favicon') <div class="invalid-feedback">{{ $message }}</div> @enderror
              <div class="form-text">@lang('settings::setting.Limit 2MB')</div>

              @if(!empty($setting->favicon_url))
                <div class="form-check mt-2">
                  <input class="form-check-input" type="checkbox" value="1" id="remove_favicon" name="remove_favicon">
                  <label class="form-check-label" for="remove_favicon">@lang('settings::setting.Delete current icon')</label>
                </div>
                <div class="mt-2">
                  <img src="{{ $setting->favicon_url }}" alt="@lang('settings::setting.Icon')" class="img-fluid rounded border" style="max-height:48px">
                </div>
              @endif
            </div>

            <div class="col-12 d-flex gap-2">
              <x-btn variant="outline-primary" type="submit" icon="bi bi-check2">@lang('settings::setting.Update')</x-btn>
              <x-btn href="{{ route('settings.index') }}" variant="outline-secondary">@lang('settings::setting.Cancel')</x-btn>
            </div>
          </form>
        </div>
      </div>

      <div class="alert alert-info mt-3 mb-0">
        <i class="bi bi-lightbulb me-1"></i>
        @lang('settings::setting.You can leave the upload fields empty if you do not want to change the images. Use the delete option to remove current images.')
      </div>
    </div>
  </div>
</div>
@endsection
