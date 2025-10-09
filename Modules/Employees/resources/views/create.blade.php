@extends('layouts.master')
@section('title', __('employees::employees.Create Employee'))
@section('content')
<div class="container py-3">
  <div class="mx-auto">
    @include('employees::partials.form', [
      'action' => route('employees.store'),
      'branches' => $branches,
      'departments' => $departments,
      'jobs' => $jobs,
      'nationalities' => $nationalities,
    ])
  </div>
</div>
@endsection
