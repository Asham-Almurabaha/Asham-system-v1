@php
  // Helpers بسيطة للـ active/collapse
  $isRoute = fn($pattern) => Request::routeIs($pattern);
  $isPath  = fn($pattern) => Request::is($pattern);
  $active  = fn($cond) => $cond ? 'active' : '';
  $open    = fn($cond) => $cond ? 'show' : '';
  $coll    = fn($cond) => $cond ? '' : 'collapsed';

  // هل مجموعة الإعدادات مفتوحة؟
  $settingsOpen = $isPath('*/setting*')
      || $isRoute('settings.*') || $isRoute('nationalities.*') || $isRoute('titles.*') || $isRoute('departments.*')|| $isRoute('cities.*') || $isRoute('branches.*')
      || $isRoute('contract_statuses.*')
      || $isRoute('installment_statuses.*') || $isRoute('installment_types.*')
      || $isRoute('products.*') || $isRoute('product_entries.*')
      || $isRoute('bank_cash_accounts.*') || $isRoute('transaction_types.*') || $isRoute('transaction_statuses.*')
      || $isRoute('categories.*')
      || $isRoute('audit-logs.*')
      || $isRoute('users.*');
@endphp

<ul class="sidebar-nav" id="sidebar-nav">

  {{-- لوحة التحكم --}}
  <li class="nav-item">
    <a class="nav-link {{ $coll($isRoute('dashboard')) }} {{ $active($isRoute('dashboard')) }}"
       href="{{ route('dashboard') }}">
      <i class="bi bi-speedometer2"></i><span>@lang('sidebar.Dashboard')</span>
    </a>
  </li>

  {{-- Employees --}}
  @role('admin')
  <li class="nav-item">
    <a class="nav-link {{ $coll($isRoute('employees.*')) }} {{ $active($isRoute('employees.*')) }}"
       href="{{ route('employees.index') }}">
      <i class="bi bi-people"></i><span>@lang('sidebar.Employees')</span>
    </a>
  </li>
  @endrole

  {{-- Customers --}}
  {{-- <li class="nav-item">
    <a class="nav-link {{ $coll($isRoute('customers.*')) }} {{ $active($isRoute('customers.*')) }}"
       href="{{ route('customers.index') }}">
      <i class="bi bi-people"></i><span>@lang('sidebar.Customers')</span>
    </a>
  </li> --}}

  {{-- Guarantors --}}
  {{-- <li class="nav-item">
    <a class="nav-link {{ $coll($isRoute('guarantors.*')) }} {{ $active($isRoute('guarantors.*')) }}"
       href="{{ route('guarantors.index') }}">
      <i class="bi bi-person-bounding-box"></i><span>@lang('sidebar.Guarantors')</span>
    </a>
  </li> --}}

  {{-- المستثمرين --}}
  {{-- <li class="nav-item">
    <a class="nav-link {{ $coll($isRoute('investors.*')) }} {{ $active($isRoute('investors.*')) }}"
       href="{{ route('investors.index') }}">
      <i class="bi bi-briefcase"></i><span>@lang('sidebar.Investors')</span>
    </a>
  </li> --}}

  {{-- العقود --}}
  {{-- <li class="nav-item">
    <a class="nav-link {{ $coll($isRoute('contracts.*')) }} {{ $active($isRoute('contracts.*')) }}"
       href="{{ route('contracts.index') }}">
      <i class="bi bi-file-earmark-text"></i><span>@lang('sidebar.Contracts')</span>
    </a>
  </li> --}}

  {{-- دفتر القيود --}}
  {{-- <li class="nav-item">
    <a class="nav-link {{ $coll($isRoute('ledger.*')) }} {{ $active($isRoute('ledger.*')) }}"
       href="{{ route('ledger.index') }}">
      <i class="bi bi-journal"></i><span>@lang('sidebar.Ledger')</span>
    </a>
  </li> --}}

  

  {{-- الإعدادات (قابلة للطي) --}}
  @role('admin')
  <li class="nav-item">
    <a class="nav-link {{ $coll($settingsOpen) }}"
       data-bs-target="#settings-nav" data-bs-toggle="collapse" href="#"
       aria-expanded="{{ $settingsOpen ? 'true' : 'false' }}">
      <i class="bi bi-gear"></i><span>@lang('sidebar.Settings')</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>

    <ul id="settings-nav" class="nav-content collapse {{ $open($settingsOpen) }}" data-bs-parent="#sidebar-nav">
      <li class="nav-heading">@lang('sidebar.General Settings')</li>
      <li>
        <a class="{{ $active($isRoute('settings.*')) }}" href="{{ route('settings.index') }}">
          <i class="bi bi-circle"></i><span>@lang('sidebar.General Setting')</span>
        </a>
      </li>
      <li class="nav-heading">@lang('sidebar.Users and Permissions')</li>
      <li>
        <a class="{{ $active($isRoute('users.*')) }}" href="{{ route('users.index') }}">
          <i class="bi bi-circle"></i><span>@lang('sidebar.Assign Roles to Users')</span>
        </a>
      </li>
      <li class="nav-heading">@lang('sidebar.Basic Data')</li>
      <li>
        <a class="{{ $active($isRoute('nationalities.*')) }}" href="{{ route('nationalities.index') }}">
          <i class="bi bi-circle"></i><span>@lang('sidebar.Nationalities')</span>
        </a>
      </li>
      <li>
        <a class="{{ $active($isRoute('departments.*')) }}" href="{{ route('departments.index') }}">
          <i class="bi bi-circle"></i><span>@lang('sidebar.Departments')</span>
        </a>
      </li>
      <li>
        <a class="{{ $active($isRoute('titles.*')) }}" href="{{ route('titles.index') }}">
          <i class="bi bi-circle"></i><span>@lang('sidebar.Job Titles')</span>
        </a>
      </li>
      <li>
        <a class="{{ $active($isRoute('cities.*')) }}" href="{{ route('cities.index') }}">
          <i class="bi bi-circle"></i><span>@lang('sidebar.Cities')</span>
        </a>
      </li>
      <li>
        <a class="{{ $active($isRoute('branches.*')) }}" href="{{ route('branches.index') }}">
          <i class="bi bi-circle"></i><span>@lang('sidebar.Branches')</span>
        </a>
      </li>
      <li>
        <a class="{{ $active($isRoute('residency-statuses.*')) }}" href="{{ route('residency-statuses.index') }}">
          <i class="bi bi-circle"></i><span>@lang('sidebar.Residency Statuses')</span>
        </a>
      </li>
      <li class="nav-heading">@lang('sidebar.Audit Logs')</li>
      <li>
        <a class="{{ $active($isRoute('audit-logs.*')) }}" href="{{ route('audit-logs.index') }}">
          <i class="bi bi-circle"></i><span>@lang('sidebar.Audit Logs')</span>
        </a>
      </li>
    </ul>
  </li>
  @endrole
</ul>
