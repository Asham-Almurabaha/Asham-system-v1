<table class="table table-striped">
  <thead>
    <tr>
      <th>@lang('phones::assignments.Employee ID')</th>
      <th>@lang('phones::assignments.Assigned At')</th>
      <th>@lang('phones::assignments.Returned At')</th>
    </tr>
  </thead>
  <tbody>
    @foreach($phone->assignments as $a)
      <tr>
        <td>{{ $a->employee_id }}</td>
        <td>{{ $a->assigned_at_hijri }}</td>
        <td>{{ $a->returned_at_hijri }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
