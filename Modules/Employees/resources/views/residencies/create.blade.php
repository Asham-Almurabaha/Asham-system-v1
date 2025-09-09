@extends('layouts.master')
@section('title', __('employees::employees.Create Residency'))
@section('content')
<div class="container py-3">
  <div class="col-lg-8 mx-auto">
    <form method="POST" action="{{ route('employees.residencies.store', $employee) }}" enctype="multipart/form-data">
      @csrf

      {{-- ============================= Residency Data ============================= --}}
      <div class="card shadow-sm mb-3">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h5 class="mb-0">@lang('employees::employees.Create Residency')</h5>
          <x-btn href="{{ route('employees.show', $employee) }}" size="sm" variant="outline-secondary" icon="bi bi-arrow-right-circle">
            @lang('employees::employees.Back')
          </x-btn>
        </div>
        <div class="card-body m-1">
          <div class="row g-3">

            {{-- Absher ID Image --}}
            <div class="col-md-6">
              <label class="form-label">@lang('employees::employees.Absher ID Image')</label>
              <input
                type="file"
                id="absher_id_image"
                name="absher_id_image"
                accept=".png,.jpg,.jpeg,.gif,.webp,.svg,.pdf"
                class="form-control @error('absher_id_image') is-invalid @enderror"
                onchange="previewImage(event, 'preview-absher', 'remove-absher')"
              >
              @error('absher_id_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
              <img id="preview-absher" class="img-fluid rounded border d-none mt-2" style="max-height:100px" alt="preview">
              <button type="button" id="remove-absher" class="btn btn-sm btn-outline-danger d-none mt-2"
                      onclick="removeImage('absher_id_image','preview-absher','remove-absher')">
                @lang('employees::employees.Delete')
              </button>
            </div>

            {{-- Tawakkalna ID Image --}}
            <div class="col-md-6">
              <label class="form-label">@lang('employees::employees.Tawakkalna ID Image')</label>
              <input
                type="file"
                id="tawakkalna_id_image"
                name="tawakkalna_id_image"
                accept=".png,.jpg,.jpeg,.gif,.webp,.svg,.pdf"
                class="form-control @error('tawakkalna_id_image') is-invalid @enderror"
                onchange="previewImage(event, 'preview-tawakkalna', 'remove-tawakkalna')"
              >
              @error('tawakkalna_id_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
              <img id="preview-tawakkalna" class="img-fluid rounded border d-none mt-2" style="max-height:100px" alt="preview">
              <button type="button" id="remove-tawakkalna" class="btn btn-sm btn-outline-danger d-none mt-2"
                      onclick="removeImage('tawakkalna_id_image','preview-tawakkalna','remove-tawakkalna')">
                @lang('employees::employees.Delete')
              </button>
            </div>

            {{-- Expiry Date --}}
            <div class="col-md-6">
              <label class="form-label">@lang('employees::employees.Residency Expiry Date')</label>
              <input
                type="date"
                name="expiry_date"
                value="{{ old('expiry_date') }}"
                class="form-control js-date @error('expiry_date') is-invalid @enderror"
                placeholder="@lang('employees::employees.Residency Expiry Date')"
                required
              >
              @error('expiry_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Employer Name --}}
            <div class="col-md-6">
              <label class="form-label">@lang('employees::employees.Employer Name')</label>
              <input
                type="text"
                name="employer_name"
                value="{{ old('employer_name') }}"
                class="form-control @error('employer_name') is-invalid @enderror"
                placeholder="{{ __('اكتب اسم صاحب العمل كما هو بالإقامة/توكلنا') }}"
              >
              @error('employer_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Employer ID --}}
            <div class="col-md-6">
              <label class="form-label">@lang('employees::employees.Employer ID')</label>
              <input
                type="text"
                name="employer_id"
                value="{{ old('employer_id') }}"
                class="form-control @error('employer_id') is-invalid @enderror"
                placeholder="{{ __('رقم صاحب العمل') }}"
              >
              @error('employer_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

          </div>
        </div>
      </div>

      {{-- ============================= Actions (separate card) ============================= --}}
      <div class="card shadow-sm">
        <div class="card-body m-1">
          <div class="d-flex gap-2">
            <x-btn variant="outline-success" type="submit" icon="bi bi-check2">@lang('users.Save')</x-btn>
            <x-btn href="{{ route('employees.show', $employee) }}" variant="outline-secondary">@lang('users.Cancel')</x-btn>
          </div>
        </div>
      </div>

    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
// ====== Image preview/remove (same logic as Create Employee) ======
function previewImage(event, previewId, removeBtnId) {
  const file = event.target.files?.[0];
  const preview = document.getElementById(previewId);
  const removeBtn = document.getElementById(removeBtnId);

  if (!preview || !removeBtn) return;

  if (file && file.type && file.type.startsWith('image/')) {
    const reader = new FileReader();
    reader.onload = function(e) {
      preview.src = e.target.result;
      preview.classList.remove('d-none');
      removeBtn.classList.remove('d-none');
    };
    reader.readAsDataURL(file);
  } else {
    // لو PDF أو ملف غير صورة، نخفي المعاينة ونظهر زر الإزالة فقط
    preview.src = '';
    preview.classList.add('d-none');
    removeBtn.classList.toggle('d-none', !file);
  }
}

function removeImage(inputId, previewId, removeBtnId) {
  const input = document.getElementById(inputId);
  const preview = document.getElementById(previewId);
  const removeBtn = document.getElementById(removeBtnId);

  if (!input || !preview || !removeBtn) return;

  input.value = '';
  preview.src = '';
  preview.classList.add('d-none');
  removeBtn.classList.add('d-none');
}
</script>
@endpush
