@extends('layouts.master')
@section('title', __('employees::employees.Create Employee'))
@section('content')
<div class="container py-3">
  <div class="col-lg-8 mx-auto">
    <form method="POST" action="{{ route('employees.store') }}" enctype="multipart/form-data">
      @csrf
      <div class="card shadow-sm mb-3">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h5 class="mb-0">@lang('employees::employees.Create Employee')</h5>
          <x-btn href="{{ route('employees.index') }}" size="sm" variant="outline-secondary" icon="bi bi-arrow-right-circle">@lang('employees::employees.Back')</x-btn>
        </div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">@lang('employees::employees.First Name (EN)')</label>
              <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" required>
              @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
              <label class="form-label">@lang('employees::employees.First Name (AR)')</label>
              <input type="text" name="first_name_ar" class="form-control @error('first_name_ar') is-invalid @enderror" value="{{ old('first_name_ar') }}" required>
              @error('first_name_ar') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
              <label class="form-label">@lang('employees::employees.Last Name (EN)')</label>
              <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}" required>
              @error('last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
              <label class="form-label">@lang('employees::employees.Last Name (AR)')</label>
              <input type="text" name="last_name_ar" class="form-control @error('last_name_ar') is-invalid @enderror" value="{{ old('last_name_ar') }}" required>
              @error('last_name_ar') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
              <label class="form-label">@lang('employees::employees.Email')</label>
              <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
              @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
              <label class="form-label">@lang('employees::employees.Photo (PNG/JPG/WEBP/SVG)')</label>
              <input type="file" id="photo" name="photo" class="form-control @error('photo') is-invalid @enderror" accept=".png,.jpg,.jpeg,.gif,.webp" onchange="previewImage(event, 'preview-photo', 'remove-photo')">
              @error('photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
              <div class="form-text">@lang('settings::setting.Limit 4MB')</div>
              <img id="preview-photo" class="img-fluid rounded border d-none mt-2" style="max-height:100px" alt="preview">
              <button type="button" id="remove-photo" class="btn btn-sm btn-outline-danger d-none mt-2" onclick="removeImage('photo','preview-photo','remove-photo')">@lang('employees::employees.Delete')</button>
            </div>
            <div class="col-md-6">
              <label class="form-label">@lang('employees::employees.Phone Numbers')</label>
              <div id="phone-container">
                @php $phones = old('phones', ['']); @endphp
                @foreach($phones as $i => $phone)
                <div class="input-group mb-2">
                  <input type="text" name="phones[]" class="form-control" value="{{ $phone }}">
                  <button type="button" class="btn btn-outline-danger remove-phone {{ $loop->first ? 'd-none' : '' }}">&times;</button>
                </div>
                @endforeach
              </div>
              @error('phones.*') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
              <button type="button" id="add-phone" class="btn btn-sm btn-outline-primary mt-2">@lang('employees::employees.Add Phone')</button>
            </div>
            <div class="col-md-6">
              <label class="form-label">@lang('employees::employees.Hire Date')</label>
              <input type="date" name="hire_date" class="form-control js-date @error('hire_date') is-invalid @enderror" value="{{ old('hire_date') }}">
              @error('hire_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
              <label class="form-label">@lang('employees::employees.Branch')</label>
              <select name="branch_id" class="form-select @error('branch_id') is-invalid @enderror" required>
                <option value="" disabled selected>@lang('employees::employees.Branch')</option>
                @foreach($branches as $b)
                  <option value="{{ $b->id }}" {{ old('branch_id') == $b->id ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? $b->name_ar : $b->name }}</option>
                @endforeach
              </select>
              @error('branch_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
              <label class="form-label">@lang('employees::employees.Department')</label>
              <select name="department_id" class="form-select @error('department_id') is-invalid @enderror">
                <option value="" selected>@lang('employees::employees.Department')</option>
                @foreach($departments as $d)
                  <option value="{{ $d->id }}" {{ old('department_id') == $d->id ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? $d->name_ar : $d->name }}</option>
                @endforeach
              </select>
              @error('department_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
              <label class="form-label">@lang('employees::employees.Title')</label>
              <select name="title_id" class="form-select @error('title_id') is-invalid @enderror">
                <option value="" selected>@lang('employees::employees.Title')</option>
                @foreach($titles as $t)
                  <option value="{{ $t->id }}" {{ old('title_id') == $t->id ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? $t->name_ar : $t->name }}</option>
                @endforeach
              </select>
              @error('title_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
              <label class="form-label">@lang('employees::employees.Nationality')</label>
              <select name="nationality_id" class="form-select @error('nationality_id') is-invalid @enderror">
                <option value="" selected>@lang('employees::employees.Nationality')</option>
                @foreach($nationalities as $n)
                  <option value="{{ $n->id }}" {{ old('nationality_id') == $n->id ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? $n->name_ar : $n->name }}</option>
                @endforeach
              </select>
              @error('nationality_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
          </div>
        </div>
      </div>

      <div class="card shadow-sm mb-3">
        <div class="card-header">
          <h5 class="mb-0">@lang('employees::employees.Identity Data')</h5>
        </div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">@lang('employees::employees.Absher ID Image')</label>
              <input type="file" id="residency_absher_id_image" name="residency_absher_id_image" class="form-control @error('residency_absher_id_image') is-invalid @enderror" accept=".png,.jpg,.jpeg,.gif,.webp" onchange="previewImage(event, 'preview-residency_absher_id_image', 'remove-residency_absher_id_image')">
              @error('residency_absher_id_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
              <img id="preview-residency_absher_id_image" class="img-fluid rounded border d-none mt-2" style="max-height:100px" alt="preview">
              <button type="button" id="remove-residency_absher_id_image" class="btn btn-sm btn-outline-danger d-none mt-2" onclick="removeImage('residency_absher_id_image','preview-residency_absher_id_image','remove-residency_absher_id_image')">@lang('employees::employees.Delete')</button>
            </div>
            <div class="col-md-6">
              <label class="form-label">@lang('employees::employees.Tawakkalna ID Image')</label>
              <input type="file" id="residency_tawakkalna_id_image" name="residency_tawakkalna_id_image" class="form-control @error('residency_tawakkalna_id_image') is-invalid @enderror" accept=".png,.jpg,.jpeg,.gif,.webp" onchange="previewImage(event, 'preview-residency_tawakkalna_id_image', 'remove-residency_tawakkalna_id_image')">
              @error('residency_tawakkalna_id_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
              <img id="preview-residency_tawakkalna_id_image" class="img-fluid rounded border d-none mt-2" style="max-height:100px" alt="preview">
              <button type="button" id="remove-residency_tawakkalna_id_image" class="btn btn-sm btn-outline-danger d-none mt-2" onclick="removeImage('residency_tawakkalna_id_image','preview-residency_tawakkalna_id_image','remove-residency_tawakkalna_id_image')">@lang('employees::employees.Delete')</button>
            </div>
            <div class="col-md-6">
              <label class="form-label">@lang('employees::employees.Residency Expiry Date')</label>
              <input type="date" name="residency_expiry_date" class="form-control js-date @error('residency_expiry_date') is-invalid @enderror" value="{{ old('residency_expiry_date') }}">
              @error('residency_expiry_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
              <label class="form-label">@lang('employees::employees.Employer Name')</label>
              <input type="text" name="residency_employer_name" class="form-control @error('residency_employer_name') is-invalid @enderror" value="{{ old('residency_employer_name') }}">
              @error('residency_employer_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
              <label class="form-label">@lang('employees::employees.Employer ID')</label>
              <input type="text" name="residency_employer_id" class="form-control @error('residency_employer_id') is-invalid @enderror" value="{{ old('residency_employer_id') }}">
              @error('residency_employer_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
          </div>
        </div>
      </div>

      <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
        <label class="form-check-label" for="is_active">@lang('employees::employees.Active')</label>
      </div>
      <div class="d-flex gap-2">
        <x-btn variant="outline-success" type="submit" icon="bi bi-check2">@lang('users.Save')</x-btn>
        <x-btn href="{{ route('employees.index') }}" variant="outline-secondary">@lang('users.Cancel')</x-btn>
      </div>
    </form>
  </div>
</div>
@endsection
@push('scripts')
<script>
document.getElementById('add-phone').addEventListener('click', function () {
    const container = document.getElementById('phone-container');
    const div = document.createElement('div');
    div.className = 'input-group mb-2';
    div.innerHTML = '<input type="text" name="phones[]" class="form-control">' +
        '<button type="button" class="btn btn-outline-danger remove-phone">&times;</button>';
    container.appendChild(div);
});
document.addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-phone')) {
        e.target.closest('.input-group').remove();
    }
});

function previewImage(event, previewId, removeBtnId) {
    const file = event.target.files[0];
    const preview = document.getElementById(previewId);
    const removeBtn = document.getElementById(removeBtnId);
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
            removeBtn.classList.remove('d-none');
        };
        reader.readAsDataURL(file);
    } else {
        preview.src = '';
        preview.classList.add('d-none');
        removeBtn.classList.add('d-none');
    }
}

function removeImage(inputId, previewId, removeBtnId) {
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    const removeBtn = document.getElementById(removeBtnId);
    input.value = '';
    preview.src = '';
    preview.classList.add('d-none');
    removeBtn.classList.add('d-none');
}
</script>
@endpush
