@extends('layouts.master')
@section('title', 'Oil Changes')
@section('content')
<div class="container py-3">
  <h1>Oil Changes for {{ $car->plate_number }}</h1>
  <ul>
    @foreach($oilChanges as $change)
      <li>{{ $change->changed_at->format('Y-m-d') }} - {{ $change->mileage }}</li>
    @endforeach
  </ul>
</div>
@endsection
