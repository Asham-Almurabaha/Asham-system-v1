<table class="table table-striped align-middle mb-0">
  <thead>
    <tr>
      <th>@lang('cars::assignments.Employee')</th>
      <th>@lang('cars::assignments.Assigned At')</th>
      <th>@lang('cars::assignments.Condition On Assign')</th>
      <th>@lang('cars::assignments.Returned At')</th>
      <th>@lang('cars::assignments.Condition On Return')</th>
      <th>@lang('cars::assignments.Notes')</th>
      <th>@lang('cars::assignments.Assigned By')</th>
      <th>@lang('cars::assignments.Returned By')</th>
      <th class="text-end">@lang('cars::assignments.Actions')</th>
    </tr>
  </thead>
  <tbody>
    @forelse($car->assignments as $a)
      <tr>
        <td>{{ optional($a->employee)->name }}</td>
        <td>{{ $a->assigned_at }}<br><small class="text-muted">{{ $a->assigned_at_hijri }}</small></td>
        <td>{{ $a->condition_on_assign }}</td>
        <td>{{ $a->returned_at }}<br><small class="text-muted">{{ $a->returned_at_hijri }}</small></td>
        <td>{{ $a->condition_on_return }}</td>
        <td>{{ $a->notes }}</td>
        <td>{{ optional($a->assignedBy)->name }}</td>
        <td>{{ optional($a->returnedBy)->name }}</td>
        <td class="text-end">
          <x-btn href="{{ route('cars.assignments.print', [$car, $a]) }}" size="sm" variant="outline-secondary" icon="bi bi-printer"></x-btn>
        </td>
      </tr>
    @empty
      <tr><td colspan="9" class="text-center text-muted">@lang('cars::assignments.No data')</td></tr>
    @endforelse
  </tbody>
</table>
