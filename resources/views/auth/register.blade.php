@extends('layouts.app')

@section('title', __('app.Register'))
@section('auth_subtitle', __('auth.register.subtitle'))

@section('form')
  <form method="POST" action="{{ route('register') }}" class="row g-3 needs-validation" novalidate>
    @csrf

    {{-- Name --}}
    <div class="col-12">
      <label for="name" class="form-label">{{ __('auth.fields.name') }}</label>
      <input  id="name"
              type="text"
              name="name"
              class="form-control @error('name') is-invalid @enderror"
              value="{{ old('name') }}"
              required
              autocomplete="name"
              autofocus
              aria-describedby="nameHelp">
      @error('name')
        <div class="invalid-feedback d-block" id="nameHelp" aria-live="polite"><strong>{{ $message }}</strong></div>
      @else
        <div class="invalid-feedback" id="nameHelp">{{ __('auth.validation.name_required') }}</div>
      @enderror
    </div>

    {{-- Email --}}
    <div class="col-12">
      <label for="email" class="form-label">{{ __('auth.fields.email') }}</label>
      <div class="input-group has-validation">
        <span class="input-group-text">@</span>
        <input  id="email"
                type="email"
                name="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}"
                required
                dir="ltr"
                autocomplete="email"
                inputmode="email"
                autocapitalize="none"
                spellcheck="false"
                aria-describedby="emailHelp">
        @error('email')
          <div class="invalid-feedback d-block" id="emailHelp" aria-live="polite"><strong>{{ $message }}</strong></div>
        @else
          <div class="invalid-feedback" id="emailHelp">{{ __('auth.validation.email_valid') }}</div>
        @enderror
      </div>
    </div>

    {{-- Phone --}}
    <div class="col-12">
      <label for="phone" class="form-label">{{ __('auth.fields.phone') }}</label>
      <input  id="phone"
              type="tel"
              name="phone"
              class="form-control @error('phone') is-invalid @enderror"
              value="{{ old('phone') }}"
              required
              dir="ltr"
              autocomplete="tel"
              inputmode="tel"
              pattern="^[0-9+\-\s()]{6,}$"
              placeholder="+966 5XXXXXXXX"
              aria-describedby="phoneHelp">
      @error('phone')
        <div class="invalid-feedback d-block" id="phoneHelp" aria-live="polite"><strong>{{ $message }}</strong></div>
      @else
        <div class="invalid-feedback" id="phoneHelp">{{ __('auth.validation.phone_valid') }}</div>
      @enderror
    </div>

    {{-- Password --}}
    <div class="col-12">
      <label for="password" class="form-label">{{ __('auth.fields.password') }}</label>
      <div class="input-group has-validation">
        <input  id="password"
                type="password"
                name="password"
                class="form-control @error('password') is-invalid @enderror"
                required
                autocomplete="new-password"
                minlength="8"
                aria-describedby="togglePassword pwdHelp">
        <button class="btn btn-outline-secondary"
                type="button"
                id="togglePassword"
                data-toggle-password
                data-target="password"
                tabindex="-1"
                aria-label="{{ __('auth.ui.toggle_password') }}">
          <i class="bi bi-eye"></i>
        </button>
        @error('password')
          <div class="invalid-feedback d-block" id="pwdHelp" aria-live="polite"><strong>{{ $message }}</strong></div>
        @else
          <div class="invalid-feedback" id="pwdHelp">{{ __('auth.validation.password_min') }}</div>
        @enderror
      </div>
    </div>

    {{-- Confirm Password --}}
    <div class="col-12">
      <label for="password-confirm" class="form-label">{{ __('auth.fields.password_confirmation') }}</label>
      <div class="input-group has-validation">
        <input  id="password-confirm"
                type="password"
                name="password_confirmation"
                class="form-control"
                required
                autocomplete="new-password"
                aria-describedby="togglePasswordConfirm confirmFeedback">
        <button class="btn btn-outline-secondary"
                type="button"
                id="togglePasswordConfirm"
                data-toggle-password
                data-target="password-confirm"
                tabindex="-1"
                aria-label="{{ __('auth.ui.toggle_password') }}">
          <i class="bi bi-eye"></i>
        </button>
        <div class="invalid-feedback" id="confirmFeedback">{{ __('auth.validation.password_mismatch') }}</div>
      </div>
    </div>

    {{-- Actions --}}
    <div class="col-12 d-flex flex-column gap-2">
      <button class="btn btn-outline-primary w-100" type="submit">{{ __('app.Register') }}</button>
      <p class="small mb-0 text-center">
        {{ __('auth.register.already') }}
        <a href="{{ route('login') }}">@lang('app.Login')</a>
      </p>
    </div>
  </form>
@endsection

@push('scripts')
<script>
(function () {
  'use strict';
  document.addEventListener('DOMContentLoaded', function () {
    // فحص Bootstrap عند الإرسال فقط
    var forms = document.querySelectorAll('.needs-validation');
    Array.prototype.slice.call(forms).forEach(function (form) {
      form.addEventListener('submit', function (event) {
        validateConfirm();
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });

    // إظهار/إخفاء كلمات المرور
    bindToggle('togglePassword', 'password');
    bindToggle('togglePasswordConfirm', 'password-confirm');

    // فحص تأكيد كلمة المرور بشكل حيّ
    ['input','change','keyup'].forEach(function (evt) {
      document.getElementById('password')?.addEventListener(evt, validateConfirm);
      document.getElementById('password-confirm')?.addEventListener(evt, validateConfirm);
    });

    function bindToggle(btnId, inputId) {
      const btn = document.getElementById(btnId);
      const inp = document.getElementById(inputId);
      if (!btn || !inp) return;
      btn.addEventListener('click', function () {
        const isText = inp.type === 'text';
        inp.type = isText ? 'password' : 'text';
        this.innerHTML = isText ? '<i class="bi bi-eye"></i>' : '<i class="bi bi-eye-slash"></i>';
      });
    }

    function validateConfirm() {
      const pwd  = document.getElementById('password');
      const conf = document.getElementById('password-confirm');
      if (!pwd || !conf) return;
      if (conf.value && pwd.value !== conf.value) {
        conf.setCustomValidity('Mismatch');
      } else {
        conf.setCustomValidity('');
      }
    }
  });
})();
</script>
@endpush

@push('scripts')
<script>
(function () {
  'use strict';

  function init() {
    // Ensure toggle works even if DOMContentLoaded already fired
    function bindToggle(btnId, inputId) {
      var btn = document.getElementById(btnId);
      var inp = document.getElementById(inputId);
      if (!btn || !inp) return;
      btn.addEventListener('click', function () {
        var isText = inp.type === 'text';
        inp.type = isText ? 'password' : 'text';
        this.innerHTML = isText ? '<i class="bi bi-eye"></i>' : '<i class="bi bi-eye-slash"></i>';
      });
    }

    bindToggle('togglePassword', 'password');
    bindToggle('togglePasswordConfirm', 'password-confirm');
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
</script>
@endpush
