<table class="table table-striped">
  <thead>
    <tr>
      <th>@lang('motorcycles::assignments.Employee ID')</th>
      <th>@lang('motorcycles::assignments.Assigned At')</th>
      <th>@lang('motorcycles::assignments.Returned At')</th>
    </tr>
  </thead>
  <tbody>
    @foreach($motorcycle->assignments as $a)
      <tr>
        <td>{{ $a->employee_id }}</td>
        <td>{{ $a->assigned_at_hijri }}</td>
        <td>{{ $a->returned_at_hijri }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
