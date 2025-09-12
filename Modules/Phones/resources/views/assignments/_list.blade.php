<table class="table table-striped align-middle mb-0">
  <thead>
    <tr>
      <th>@lang('phones::assignments.Employee')</th>
      <th>@lang('phones::assignments.Assigned At')</th>
      <th>@lang('phones::assignments.Condition On Assign')</th>
      <th>@lang('phones::assignments.Returned At')</th>
      <th>@lang('phones::assignments.Condition On Return')</th>
      <th>@lang('phones::assignments.Notes')</th>
      <th>@lang('phones::assignments.Assigned By')</th>
      <th>@lang('phones::assignments.Returned By')</th>
      <th class="text-end">@lang('phones::assignments.Actions')</th>
    </tr>
  </thead>
  <tbody>
    @forelse($phone->assignments as $a)
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
          <x-btn href="{{ route('phones.assignments.print', [$phone, $a]) }}" size="sm" variant="outline-secondary" icon="bi bi-printer"></x-btn>
        </td>
      </tr>
    @empty
      <tr><td colspan="9" class="text-center text-muted">@lang('phones::assignments.No data')</td></tr>
    @endforelse
  </tbody>
</table>
