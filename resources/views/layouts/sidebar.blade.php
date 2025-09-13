@php
  // Helpers بسيطة للـ active/collapse
  $isRoute = fn($pattern) => Request::routeIs($pattern);
  $isPath  = fn($pattern) => Request::is($pattern);
  $active  = fn($cond) => $cond ? 'active' : '';
  $open    = fn($cond) => $cond ? 'show' : '';
  $coll    = fn($cond) => $cond ? '' : 'collapsed';

  // open states for settings groups
  $generalSettingsOpen = $isRoute('settings.*') || $isRoute('nationalities.*') || $isRoute('users.*') || $isRoute('companies.*') || $isRoute('cities.*') || $isRoute('branches.*') || $isRoute('departments.*') || $isRoute('jobs.*') || $isRoute('audit-logs.*');
  $employeeSettingsOpen = $isRoute('residency-statuses.*') || $isRoute('work-statuses.*');
  $carSettingsOpen = $isRoute('car-years.*') || $isRoute('car-colors.*') || $isRoute('car-types.*') || $isRoute('car-brands.*')
      || $isRoute('car-models.*') || $isRoute('car-statuses.*') || $isRoute('car-document-data-types.*')
      || $isRoute('car-delegation-types.*') || $isRoute('violation-types.*') || $isRoute('violation-payment-statuses.*');
  $carsOpen = $isRoute('cars.*');
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

  <li class="nav-item">
    <a class="nav-link {{ $coll($carsOpen) }}" data-bs-target="#cars-nav" data-bs-toggle="collapse" href="#" aria-expanded="{{ $carsOpen ? 'true' : 'false' }}">
      <i class="bi bi-car-front"></i><span>@lang('sidebar.Cars')</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="cars-nav" class="nav-content collapse {{ $open($carsOpen) }}" data-bs-parent="#sidebar-nav">
      <li>
        <a class="{{ $active($isRoute('cars.*')) }}" href="{{ route('cars.index') }}">
          <i class="bi bi-circle"></i><span>@lang('sidebar.Cars')</span>
        </a>
      </li>
    </ul>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ $coll($isRoute('motorcycles.*')) }} {{ $active($isRoute('motorcycles.*')) }}" href="{{ route('motorcycles.index') }}">
      <i class="bi bi-bicycle"></i><span>@lang('sidebar.Motorcycles')</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ $coll($isRoute('phones.*')) }} {{ $active($isRoute('phones.*')) }}" href="{{ route('phones.index') }}">
      <i class="bi bi-phone"></i><span>@lang('sidebar.Phones')</span>
    </a>
  </li>

  {{-- الإعدادات --}}
  @role('admin')
  <li class="nav-item">
    <a class="nav-link {{ $coll($generalSettingsOpen) }}" data-bs-target="#general-settings-nav" data-bs-toggle="collapse" href="#" aria-expanded="{{ $generalSettingsOpen ? 'true' : 'false' }}">
      <i class="bi bi-gear"></i><span>@lang('sidebar.General Settings')</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="general-settings-nav" class="nav-content collapse {{ $open($generalSettingsOpen) }}" data-bs-parent="#sidebar-nav">
      <li>
        <a class="{{ $active($isRoute('settings.*')) }}" href="{{ route('settings.index') }}">
          <i class="bi bi-circle"></i><span>@lang('sidebar.General Setting')</span>
        </a>
      </li>

      <li>
        <a class="{{ $active($isRoute('users.*')) }}" href="{{ route('users.index') }}">
          <i class="bi bi-circle"></i><span>@lang('sidebar.Users')</span>
        </a>
      </li>
      <li>
        <a class="{{ $active($isRoute('companies.*')) }}" href="{{ route('companies.index') }}">
          <i class="bi bi-circle"></i><span>@lang('sidebar.Companies')</span>
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
        <a class="{{ $active($isRoute('departments.*')) }}" href="{{ route('departments.index') }}">
          <i class="bi bi-circle"></i><span>@lang('sidebar.Departments')</span>
        </a>
      </li>
      <li>
        <a class="{{ $active($isRoute('jobs.*')) }}" href="{{ route('jobs.index') }}">
          <i class="bi bi-circle"></i><span>@lang('sidebar.Jobs')</span>
        </a>
      </li>

      <li>
        <a class="{{ $active($isRoute('nationalities.*')) }}" href="{{ route('nationalities.index') }}">
          <i class="bi bi-circle"></i><span>@lang('sidebar.Nationalities')</span>
        </a>
      </li>

      <li>
        <a class="{{ $active($isRoute('audit-logs.*')) }}" href="{{ route('audit-logs.index') }}">
          <i class="bi bi-circle"></i><span>@lang('sidebar.Audit Logs')</span>
        </a>
      </li>
    </ul>
  </li>

  <li class="nav-item">
    <a class="nav-link {{ $coll($employeeSettingsOpen) }}" data-bs-target="#employee-settings-nav" data-bs-toggle="collapse" href="#" aria-expanded="{{ $employeeSettingsOpen ? 'true' : 'false' }}">
      <i class="bi bi-people"></i><span>@lang('sidebar.Employee Settings')</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="employee-settings-nav" class="nav-content collapse {{ $open($employeeSettingsOpen) }}" data-bs-parent="#sidebar-nav">

      
      <li>
        <a class="{{ $active($isRoute('residency-statuses.*')) }}" href="{{ route('residency-statuses.index') }}">
          <i class="bi bi-circle"></i><span>@lang('sidebar.Residency Statuses')</span>
        </a>
      </li>
      <li>
        <a class="{{ $active($isRoute('work-statuses.*')) }}" href="{{ route('work-statuses.index') }}">
          <i class="bi bi-circle"></i><span>@lang('sidebar.Work Statuses')</span>
        </a>
      </li>
    </ul>
  </li>

  <li class="nav-item">
    <a class="nav-link {{ $coll($carSettingsOpen) }}" data-bs-target="#car-settings-nav" data-bs-toggle="collapse" href="#" aria-expanded="{{ $carSettingsOpen ? 'true' : 'false' }}">
      <i class="bi bi-car-front"></i><span>@lang('sidebar.Car Settings')</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="car-settings-nav" class="nav-content collapse {{ $open($carSettingsOpen) }}" data-bs-parent="#sidebar-nav">
      <li>
        <a class="{{ $active($isRoute('car-years.*')) }}" href="{{ route('car-years.index') }}">
          <i class="bi bi-circle"></i><span>@lang('sidebar.Car Years')</span>
        </a>
      </li>
      <li>
        <a class="{{ $active($isRoute('car-colors.*')) }}" href="{{ route('car-colors.index') }}">
          <i class="bi bi-circle"></i><span>@lang('sidebar.Car Colors')</span>
        </a>
      </li>
      <li>
        <a class="{{ $active($isRoute('car-types.*')) }}" href="{{ route('car-types.index') }}">
          <i class="bi bi-circle"></i><span>@lang('sidebar.Car Types')</span>
        </a>
      </li>
      <li>
        <a class="{{ $active($isRoute('car-brands.*')) }}" href="{{ route('car-brands.index') }}">
          <i class="bi bi-circle"></i><span>@lang('sidebar.Car Brands')</span>
        </a>
      </li>
      <li>
        <a class="{{ $active($isRoute('car-models.*')) }}" href="{{ route('car-models.index') }}">
          <i class="bi bi-circle"></i><span>@lang('sidebar.Car Models')</span>
        </a>
      </li>
      <li>
        <a class="{{ $active($isRoute('car-statuses.*')) }}" href="{{ route('car-statuses.index') }}">
          <i class="bi bi-circle"></i><span>@lang('sidebar.Car Statuses')</span>
        </a>
      </li>
      <li>
        <a class="{{ $active($isRoute('car-document-data-types.*')) }}" href="{{ route('car-document-data-types.index') }}">
          <i class="bi bi-circle"></i><span>@lang('sidebar.Car Document Data Types')</span>
        </a>
      </li>
      <li>
        <a class="{{ $active($isRoute('car-delegation-types.*')) }}" href="{{ route('car-delegation-types.index') }}">
          <i class="bi bi-circle"></i><span>@lang('sidebar.Car Delegation Types')</span>
        </a>
      </li>
      <li>
        <a class="{{ $active($isRoute('violation-types.*')) }}" href="{{ route('violation-types.index') }}">
          <i class="bi bi-circle"></i><span>@lang('sidebar.Violation Types')</span>
        </a>
      </li>
      <li>
        <a class="{{ $active($isRoute('violation-payment-statuses.*')) }}" href="{{ route('violation-payment-statuses.index') }}">
          <i class="bi bi-circle"></i><span>@lang('sidebar.Violation Payment Statuses')</span>
        </a>
      </li>
    </ul>
  </li>
  @endrole
</ul>
