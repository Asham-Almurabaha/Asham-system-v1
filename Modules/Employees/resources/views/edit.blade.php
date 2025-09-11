@extends('layouts.master')
@section('title', __('employees::employees.Edit Employee'))
@section('content')
<div class="container py-3">
  <div class="col-lg-8 mx-auto">

    {{-- ============================= Edit Employee ============================= --}}
    <div class="card shadow-sm mb-3">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">@lang('employees::employees.Edit Employee')</h5>
        <x-btn href="{{ route(Route::has('hr.employees.index') ? 'hr.employees.index' : 'employees.index') }}" size="sm" variant="outline-secondary" icon="bi bi-arrow-right-circle">@lang('employees::employees.Back')</x-btn>
      </div>
      <div class="card-body m-1">
        <form method="POST" action="{{ route(Route::has('hr.employees.update') ? 'hr.employees.update' : 'employees.update', $item) }}" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          @php $residency = $item->residencies->first(); @endphp

          {{-- ============================= Basic Info ============================= --}}
          <div class="row g-3">
            {{-- Arabic Names --}}
            <div class="col-md-6">
              <label class="form-label">@lang('employees::employees.First Name (AR)')</label>
              <input type="text" name="first_name_ar" class="form-control @error('first_name_ar') is-invalid @enderror" value="{{ old('first_name_ar', $item->first_name_ar) }}" required>
              @error('first_name_ar') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
              <label class="form-label">@lang('employees::employees.Last Name (AR)')</label>
              <input type="text" name="last_name_ar" class="form-control @error('last_name_ar') is-invalid @enderror" value="{{ old('last_name_ar', $item->last_name_ar) }}" required>
              @error('last_name_ar') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- English Names --}}
            <div class="col-md-6">
              <label class="form-label">@lang('employees::employees.First Name (EN)')</label>
              <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name', $item->first_name) }}" required>
              @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
              <label class="form-label">@lang('employees::employees.Last Name (EN)')</label>
              <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name', $item->last_name) }}" required>
              @error('last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Email --}}
            <div class="col-md-6">
              <label class="form-label">@lang('employees::employees.Email')</label>
              <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $item->email) }}" required>
              @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Photo --}}
            <div class="col-12">
              <label class="form-label">@lang('employees::employees.Photo')</label>
              <input type="file" id="photo" name="photo" class="form-control @error('photo') is-invalid @enderror"
                     accept=".png,.jpg,.jpeg,.gif,.webp,.svg"
                     onchange="previewImage(event, 'preview-photo', 'remove-photo')">
              @error('photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
              <img id="preview-photo" src="{{ $item->photo_url }}"
                   class="img-fluid rounded border {{ $item->photo_url ? '' : 'd-none' }} mt-2"
                   style="max-height:100px" alt="preview"
                   onerror="this.classList.add('d-none');">
              <button type="button" id="remove-photo" class="btn btn-sm btn-outline-danger d-none mt-2"
                      onclick="removeImage('photo','preview-photo','remove-photo')">
                @lang('employees::employees.Delete')
              </button>
            </div>

            {{-- Phones --}}
            <div class="col-md-6">
              <label class="form-label">@lang('employees::employees.Phone Numbers')</label>
              <div id="phone-container">
                @php $phones = old('phones', $item->phones->pluck('phone')->toArray() ?: ['']); @endphp
                @foreach($phones as $phone)
                <div class="input-group mb-2">
                  <input type="text" name="phones[]" class="form-control" value="{{ $phone }}" placeholder="05xxxxxxxx">
                  <button type="button" class="btn btn-outline-danger remove-phone {{ $loop->first ? 'd-none' : '' }}">&times;</button>
                </div>
                @endforeach
              </div>
              <button type="button" id="add-phone" class="btn btn-sm btn-outline-primary mt-2">@lang('employees::employees.Add Phone')</button>
            </div>
          </div>
        </div>
      </div>

      {{-- ============================= Identity Data ============================= --}}
      <div class="card shadow-sm mb-3">
        <div class="card-header">
          <h5 class="mb-0">@lang('employees::employees.Identity Data')</h5>
        </div>
        <div class="card-body m-1">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">@lang('employees::employees.Absher ID Image')</label>
              <input type="file" id="residency_absher_id_image" name="residency_absher_id_image"
                     class="form-control" accept=".png,.jpg,.jpeg"
                     onchange="previewImage(event, 'preview-residency_absher_id_image', 'remove-residency_absher_id_image')">
              <img id="preview-residency_absher_id_image"
                   src="{{ $residency?->absher_id_image ? Storage::url($residency->absher_id_image) : '' }}"
                   class="img-fluid rounded border {{ $residency?->absher_id_image ? '' : 'd-none' }} mt-2"
                   style="max-height:100px" alt="preview"
                   onerror="this.classList.add('d-none');">
              <button type="button" id="remove-residency_absher_id_image" class="btn btn-sm btn-outline-danger d-none mt-2"
                      onclick="removeImage('residency_absher_id_image','preview-residency_absher_id_image','remove-residency_absher_id_image')">
                @lang('employees::employees.Delete')
              </button>
            </div>
            <div class="col-md-6">
              <label class="form-label">@lang('employees::employees.Tawakkalna ID Image')</label>
              <input type="file" id="residency_tawakkalna_id_image" name="residency_tawakkalna_id_image"
                     class="form-control" accept=".png,.jpg,.jpeg"
                     onchange="previewImage(event, 'preview-residency_tawakkalna_id_image', 'remove-residency_tawakkalna_id_image')">
              <img id="preview-residency_tawakkalna_id_image"
                   src="{{ $residency?->tawakkalna_id_image ? Storage::url($residency->tawakkalna_id_image) : '' }}"
                   class="img-fluid rounded border {{ $residency?->tawakkalna_id_image ? '' : 'd-none' }} mt-2"
                   style="max-height:100px" alt="preview"
                   onerror="this.classList.add('d-none');">
              <button type="button" id="remove-residency_tawakkalna_id_image" class="btn btn-sm btn-outline-danger d-none mt-2"
                      onclick="removeImage('residency_tawakkalna_id_image','preview-residency_tawakkalna_id_image','remove-residency_tawakkalna_id_image')">
                @lang('employees::employees.Delete')
              </button>
            </div>
          </div>
        </div>
      </div>

      {{-- ============================= Actions ============================= --}}
      <div class="card shadow-sm">
        <div class="card-body m-1">
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                   {{ old('is_active', $item->is_active) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">@lang('employees::employees.Active')</label>
          </div>
          <div class="d-flex gap-2">
            <x-btn variant="outline-success" type="submit">@lang('users.Save')</x-btn>
            <x-btn href="{{ route('employees.index') }}" variant="outline-secondary">@lang('users.Cancel')</x-btn>
          </div>
        </div>
      </div>

        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
function initPreview(imgId, removeBtnId = null) {
  const img = document.getElementById(imgId);
  if (!img) return;
  const hasSrc = (img.getAttribute('src') || '').trim().length > 0;

  if (!hasSrc) {
    img.classList.add('d-none');
    if (removeBtnId) document.getElementById(removeBtnId)?.classList.add('d-none');
  }
  img.addEventListener('error', () => {
    img.classList.add('d-none');
    if (removeBtnId) document.getElementById(removeBtnId)?.classList.add('d-none');
  });
}

document.addEventListener('DOMContentLoaded', () => {
  initPreview('preview-photo','remove-photo');
  initPreview('preview-residency_absher_id_image','remove-residency_absher_id_image');
  initPreview('preview-residency_tawakkalna_id_image','remove-residency_tawakkalna_id_image');
});

function previewImage(event, previewId, removeBtnId) {
  const file = event.target.files?.[0];
  const preview = document.getElementById(previewId);
  const removeBtn = document.getElementById(removeBtnId);
  if (file && file.type.startsWith('image/')) {
    const reader = new FileReader();
    reader.onload = e => {
      preview.src = e.target.result;
      preview.classList.remove('d-none');
      removeBtn?.classList.remove('d-none');
    };
    reader.readAsDataURL(file);
  } else {
    preview.src = '';
    preview.classList.add('d-none');
    removeBtn?.classList.add('d-none');
  }
}

function removeImage(inputId, previewId, removeBtnId) {
  const input = document.getElementById(inputId);
  const preview = document.getElementById(previewId);
  const removeBtn = document.getElementById(removeBtnId);
  input.value = '';
  preview.src = '';
  preview.classList.add('d-none');
  removeBtn?.classList.add('d-none');
}
</script>
@endpush
