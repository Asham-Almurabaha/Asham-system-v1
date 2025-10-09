@extends('layouts.master')
@section('title', __('employees::employees.Edit Employee'))
@section('content')
<div class="container py-3">
  <div class="mx-auto">
    @include('employees::partials.form', [
      'action' => route('employees.update', $item),
      'method' => 'PUT',
      'item' => $item,
      'branches' => $branches,
      'departments' => $departments,
      'jobs' => $jobs,
      'nationalities' => $nationalities,
    ])
  </div>
</div>
@endsection
