@php
    use Illuminate\Support\Facades\Storage;

    $action = $action ?? '#';
    $method = $method ?? 'POST';
    $item = $item ?? null;
    $branches = $branches ?? collect();
    $departments = $departments ?? collect();
    $jobs = $jobs ?? collect();
    $nationalities = $nationalities ?? collect();

    $isEdit = !is_null($item);
    $residency = $isEdit ? $item->residencies->first() : null;
    $phones = old('phones', $isEdit ? ($item->phones->pluck('phone')->toArray() ?: ['']) : ['']);
    $selectedBranchId = old('branch_id', $isEdit ? $item->branch_id : null);
    $selectedDepartmentId = old('department_id', $isEdit ? $item->department_id : null);
    $selectedJobId = old('job_id', $isEdit ? $item->job_id : null);
    $selectedNationalityId = old('nationality_id', $isEdit ? $item->nationality_id : null);
    $isActive = old('is_active', $isEdit ? $item->is_active : true);

    $jobsForJs = collect($jobs)
        ->map(fn ($job) => [
            'id' => $job->id,
            'name' => $job->name_en,
            'name_ar' => $job->name_ar,
            'department_id' => $job->department_id,
        ])
        ->values()
        ->toArray();
@endphp

<form method="POST" action="{{ $action }}" enctype="multipart/form-data">
  @csrf
  @if (in_array(strtoupper($method), ['PUT', 'PATCH', 'DELETE']))
    @method($method)
  @endif
  @if($isEdit)
    <input type="hidden" name="remove_photo" id="remove_photo" value="0">
  @endif

  {{-- ============================= Basic Info ============================= --}}
  <div class="card shadow-sm mb-3">
    <div class="card-header d-flex align-items-center justify-content-between">
      <h5 class="mb-0">
        @lang($isEdit ? 'employees::employees.Edit Employee' : 'employees::employees.Create Employee')
      </h5>
      <x-btn href="{{ route('employees.index') }}" size="sm" variant="outline-secondary" icon="bi bi-arrow-right-circle">
        @lang('employees::employees.Back')
      </x-btn>
    </div>
    <div class="card-body m-1">
      <div class="row g-3">
        {{-- Arabic Names --}}
        <div class="col-md-6">
          <label class="form-label">@lang('employees::employees.First Name (AR)')</label>
          <input type="text" name="first_name_ar" class="form-control @error('first_name_ar') is-invalid @enderror" value="{{ old('first_name_ar', $isEdit ? $item->first_name_ar : null) }}" placeholder="{{ __('اكتب الاسم الأول بالعربية (مثال: خالد)') }}" required>
          @error('first_name_ar') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-6">
          <label class="form-label">@lang('employees::employees.Last Name (AR)')</label>
          <input type="text" name="last_name_ar" class="form-control @error('last_name_ar') is-invalid @enderror" value="{{ old('last_name_ar', $isEdit ? $item->last_name_ar : null) }}" placeholder="{{ __('اكتب اسم العائلة بالعربية (مثال: الحربي)') }}" required>
          @error('last_name_ar') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- English Names --}}
        <div class="col-md-6">
          <label class="form-label">@lang('employees::employees.First Name (EN)')</label>
          <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name', $isEdit ? $item->first_name : null) }}" placeholder="{{ __('Enter first name in English (e.g., Khaled)') }}" required>
          @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-6">
          <label class="form-label">@lang('employees::employees.Last Name (EN)')</label>
          <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name', $isEdit ? $item->last_name : null) }}" placeholder="{{ __('Enter last name in English (e.g., Al‑Harbi)') }}" required>
          @error('last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Email --}}
        <div class="col-md-6">
          <label class="form-label">@lang('employees::employees.Email')</label>
          <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $isEdit ? $item->email : null) }}" placeholder="{{ __('example@company.com') }}" required>
          @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Photo --}}
        <div class="col-12">
          <label class="form-label">@lang('employees::employees.Photo')</label>
          <input type="file" id="photo" name="photo" class="form-control @error('photo') is-invalid @enderror" accept=".png,.jpg,.jpeg,.gif,.webp,.svg" onchange="previewImage(event, 'preview-photo', 'remove-photo')">
          @error('photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
          <img id="preview-photo" src="{{ $isEdit ? $item->photo_url : '' }}" class="img-fluid rounded border {{ $isEdit && $item->photo_url ? '' : 'd-none' }} mt-2" style="max-height:100px" alt="preview" onerror="this.classList.add('d-none');">
          <button type="button" id="remove-photo" class="btn btn-sm btn-outline-danger {{ $isEdit && $item->photo_url ? '' : 'd-none' }} mt-2" onclick="removeImage('photo','preview-photo','remove-photo')">
            @lang('employees::employees.Delete')
          </button>
        </div>

        {{-- Phones --}}
        <div class="col-md-6">
          <label class="form-label">@lang('employees::employees.Phone Numbers')</label>
          <div id="phone-container">
            @foreach($phones as $index => $phone)
              <div class="input-group mb-2">
                <input type="text" name="phones[]" class="form-control" value="{{ $phone }}" placeholder="{{ __('05xxxxxxxx') }}">
                <button type="button" class="btn btn-outline-danger remove-phone {{ $loop->first ? 'd-none' : '' }}">&times;</button>
              </div>
            @endforeach
          </div>
          @error('phones.*') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
          <button type="button" id="add-phone" class="btn btn-sm btn-outline-primary mt-2">@lang('employees::employees.Add Phone')</button>
        </div>

        {{-- Hire Date --}}
        <div class="col-md-6">
          <label class="form-label">@lang('employees::employees.Hire Date')</label>
          <input type="date" name="hire_date" class="form-control js-date @error('hire_date') is-invalid @enderror" value="{{ old('hire_date', $isEdit && $item->hire_date ? $item->hire_date->format('Y-m-d') : null) }}" placeholder="@lang('employees::employees.Hire Date')">
          @error('hire_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Branch --}}
        <div class="col-md-6">
          <label class="form-label">@lang('employees::employees.Branch')</label>
          <select name="branch_id" class="form-select @error('branch_id') is-invalid @enderror" required>
            <option value="" disabled {{ $selectedBranchId ? '' : 'selected' }}>@lang('employees::employees.Branch')</option>
            @foreach($branches as $branch)
              <option value="{{ $branch->id }}" {{ (string) $selectedBranchId === (string) $branch->id ? 'selected' : '' }}>
                {{ app()->getLocale() === 'ar' ? $branch->name_ar : $branch->name_en }}
              </option>
            @endforeach
          </select>
          @error('branch_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Department --}}
        <div class="col-md-6">
          <label class="form-label">@lang('employees::employees.Department')</label>
          <select name="department_id" id="department_id" class="form-select @error('department_id') is-invalid @enderror">
            <option value="" {{ $selectedDepartmentId ? '' : 'selected' }}>{{ __('اختر القسم') }}</option>
            @foreach($departments as $department)
              <option value="{{ $department->id }}" {{ (string) $selectedDepartmentId === (string) $department->id ? 'selected' : '' }}>
                {{ app()->getLocale() === 'ar' ? $department->name_ar : $department->name_en }}
              </option>
            @endforeach
          </select>
          @error('department_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Job (depends on department) --}}
        <div class="col-md-6 {{ $selectedDepartmentId ? '' : 'd-none' }}" id="job-container">
          <label class="form-label">@lang('employees::employees.job')</label>
          <select name="job_id" id="job_id" class="form-select @error('job_id') is-invalid @enderror">
            <option value="" {{ $selectedJobId ? '' : 'selected' }}>{{ __('اختر المسمى الوظيفي') }}</option>
            @foreach(collect($jobs)->where('department_id', $selectedDepartmentId) as $job)
              <option value="{{ $job->id }}" {{ (string) $selectedJobId === (string) $job->id ? 'selected' : '' }}>
                {{ app()->getLocale() === 'ar' ? ($job->name_ar ?? $job->name_en) : ($job->name_en ?? $job->name_ar) }}
              </option>
            @endforeach
          </select>
          @error('job_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Nationality --}}
        <div class="col-md-6">
          <label class="form-label">@lang('employees::employees.Nationality')</label>
          <select name="nationality_id" class="form-select @error('nationality_id') is-invalid @enderror">
            <option value="" {{ $selectedNationalityId ? '' : 'selected' }}>@lang('employees::employees.Nationality')</option>
            @foreach($nationalities as $nationality)
              <option value="{{ $nationality->id }}" {{ (string) $selectedNationalityId === (string) $nationality->id ? 'selected' : '' }}>
                {{ app()->getLocale() === 'ar' ? $nationality->name_ar : $nationality->name_en }}
              </option>
            @endforeach
          </select>
          @error('nationality_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
          <input type="file" id="residency_absher_id_image" name="residency_absher_id_image" class="form-control @error('residency_absher_id_image') is-invalid @enderror" accept=".png,.jpg,.jpeg,.gif,.webp,.svg" onchange="previewImage(event, 'preview-residency_absher_id_image', 'remove-residency_absher_id_image')">
          @error('residency_absher_id_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
          <img id="preview-residency_absher_id_image" src="{{ $residency?->absher_id_image ? Storage::url($residency->absher_id_image) : '' }}" class="img-fluid rounded border {{ $residency?->absher_id_image ? '' : 'd-none' }} mt-2" style="max-height:100px" alt="preview" onerror="this.classList.add('d-none');">
          <button type="button" id="remove-residency_absher_id_image" class="btn btn-sm btn-outline-danger {{ $residency?->absher_id_image ? '' : 'd-none' }} mt-2" onclick="removeImage('residency_absher_id_image','preview-residency_absher_id_image','remove-residency_absher_id_image')">
            @lang('employees::employees.Delete')
          </button>
        </div>
        <div class="col-md-6">
          <label class="form-label">@lang('employees::employees.Tawakkalna ID Image')</label>
          <input type="file" id="residency_tawakkalna_id_image" name="residency_tawakkalna_id_image" class="form-control @error('residency_tawakkalna_id_image') is-invalid @enderror" accept=".png,.jpg,.jpeg,.gif,.webp,.svg" onchange="previewImage(event, 'preview-residency_tawakkalna_id_image', 'remove-residency_tawakkalna_id_image')">
          @error('residency_tawakkalna_id_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
          <img id="preview-residency_tawakkalna_id_image" src="{{ $residency?->tawakkalna_id_image ? Storage::url($residency->tawakkalna_id_image) : '' }}" class="img-fluid rounded border {{ $residency?->tawakkalna_id_image ? '' : 'd-none' }} mt-2" style="max-height:100px" alt="preview" onerror="this.classList.add('d-none');">
          <button type="button" id="remove-residency_tawakkalna_id_image" class="btn btn-sm btn-outline-danger {{ $residency?->tawakkalna_id_image ? '' : 'd-none' }} mt-2" onclick="removeImage('residency_tawakkalna_id_image','preview-residency_tawakkalna_id_image','remove-residency_tawakkalna_id_image')">
            @lang('employees::employees.Delete')
          </button>
        </div>
        <div class="col-md-6">
          <label class="form-label">@lang('employees::employees.Residency Expiry Date')</label>
          <input type="date" name="residency_expiry_date" class="form-control js-date @error('residency_expiry_date') is-invalid @enderror" value="{{ old('residency_expiry_date', $residency?->expiry_date ? $residency->expiry_date->format('Y-m-d') : null) }}" placeholder="@lang('employees::employees.Residency Expiry Date')">
          @error('residency_expiry_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-6">
          <label class="form-label">@lang('employees::employees.Employer Name')</label>
          <input type="text" name="residency_employer_name" class="form-control @error('residency_employer_name') is-invalid @enderror" value="{{ old('residency_employer_name', $residency?->employer_name) }}" placeholder="{{ __('اكتب اسم صاحب العمل كما هو بالإقامة/توكلنا') }}">
          @error('residency_employer_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-6">
          <label class="form-label">@lang('employees::employees.Employer ID')</label>
          <input type="text" name="residency_employer_id" class="form-control @error('residency_employer_id') is-invalid @enderror" value="{{ old('residency_employer_id', $residency?->employer_id) }}" placeholder="{{ __('رقم صاحب العمل') }}">
          @error('residency_employer_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
      </div>
    </div>
  </div>

  {{-- ============================= Actions ============================= --}}
  <div class="card shadow-sm mb-3">
    <div class="card-body p-20">
      <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" {{ $isActive ? 'checked' : '' }}>
        <label class="form-check-label" for="is_active">@lang('employees::employees.Active')</label>
      </div>
      <div class="d-flex gap-2">
        <x-btn
          variant="outline-success"
          type="submit"
          :icon="$isEdit ? null : 'bi bi-check2'"
        >@lang('users.Save')</x-btn>
        <x-btn href="{{ route('employees.index') }}" variant="outline-secondary">@lang('users.Cancel')</x-btn>
      </div>
    </div>
  </div>
</form>

@push('scripts')
  <script>
    function previewImage(event, previewId, removeBtnId) {
      const file = event.target.files?.[0];
      const preview = document.getElementById(previewId);
      const removeBtn = document.getElementById(removeBtnId);
      const removePhotoInput = document.getElementById('remove_photo');
      if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = e => {
          preview.src = e.target.result;
          preview.classList.remove('d-none');
          removeBtn?.classList.remove('d-none');
        };
        reader.readAsDataURL(file);
        if (removePhotoInput) {
          removePhotoInput.value = '0';
        }
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
      const removePhotoInput = document.getElementById('remove_photo');
      if (input) {
        input.value = '';
      }
      if (preview) {
        preview.src = '';
        preview.classList.add('d-none');
      }
      removeBtn?.classList.add('d-none');
      if (removePhotoInput && inputId === 'photo') {
        removePhotoInput.value = '1';
      }
    }

    document.addEventListener('DOMContentLoaded', () => {
      const previewConfigs = [
        { preview: 'preview-photo', remove: 'remove-photo' },
        { preview: 'preview-residency_absher_id_image', remove: 'remove-residency_absher_id_image' },
        { preview: 'preview-residency_tawakkalna_id_image', remove: 'remove-residency_tawakkalna_id_image' },
      ];

      previewConfigs.forEach(({ preview, remove }) => {
        const previewEl = document.getElementById(preview);
        const removeBtn = document.getElementById(remove);
        if (!previewEl) return;
        const hasSrc = (previewEl.getAttribute('src') || '').trim().length > 0;
        if (hasSrc) {
          previewEl.classList.remove('d-none');
          removeBtn?.classList.remove('d-none');
        }
      });
    });

    const addPhoneButton = document.getElementById('add-phone');
    addPhoneButton?.addEventListener('click', function () {
      const container = document.getElementById('phone-container');
      if (!container) {
        return;
      }
      const div = document.createElement('div');
      div.className = 'input-group mb-2';
      div.innerHTML = `
        <input type="text" name="phones[]" class="form-control" placeholder="{{ __('05xxxxxxxx') }}">
        <button type="button" class="btn btn-outline-danger remove-phone">&times;</button>
      `;
      container.appendChild(div);
    });

    document.addEventListener('click', function (e) {
      if (e.target.classList.contains('remove-phone')) {
        e.target.closest('.input-group').remove();
      }
    });

    const alljobs = @json($jobsForJs);
    const locale = @js(app()->getLocale());
    const departmentSelect = document.getElementById('department_id');
    const jobSelect = document.getElementById('job_id');
    const jobContainer = document.getElementById('job-container');
    let selectedJobId = @json($selectedJobId);

    function updatejobs() {
      if (!departmentSelect || !jobSelect || !jobContainer) {
        return;
      }
      const depId = departmentSelect.value;
      jobSelect.innerHTML = `<option value="" ${selectedJobId ? '' : 'selected'}>{{ __('اختر المسمى الوظيفي') }}</option>`;
      if (depId) {
        const filtered = alljobs.filter(job => String(job.department_id) === String(depId));
        filtered.forEach(job => {
          const option = document.createElement('option');
          option.value = job.id;
          option.textContent = locale === 'ar'
            ? (job.name_ar ?? job.name)
            : (job.name ?? job.name_ar);
          if (String(selectedJobId) === String(job.id)) {
            option.selected = true;
          }
          jobSelect.appendChild(option);
        });
        jobContainer.classList.toggle('d-none', filtered.length === 0);
      } else {
        jobContainer.classList.add('d-none');
      }
    }

    departmentSelect?.addEventListener('change', () => {
      selectedJobId = '';
      updatejobs();
    });

    updatejobs();
  </script>
@endpush
