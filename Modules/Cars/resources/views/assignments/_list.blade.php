<table class="table table-striped">
  <thead>
    <tr>
      <th>@lang('cars::assignments.Employee ID')</th>
      <th>@lang('cars::assignments.Assigned At')</th>
      <th>@lang('cars::assignments.Returned At')</th>
    </tr>
  </thead>
  <tbody>
    @foreach($car->assignments as $a)
      <tr>
        <td>{{ $a->employee_id }}</td>
        <td>{{ $a->assigned_at_hijri }}</td>
        <td>{{ $a->returned_at_hijri }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
