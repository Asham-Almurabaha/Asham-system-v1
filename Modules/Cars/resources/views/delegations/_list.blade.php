<table class="table table-striped align-middle mb-0">
  <thead>
    <tr>
      <th>@lang('cars::delegations.Employee')</th>
      <th>@lang('cars::delegations.Type')</th>
      <th>@lang('cars::delegations.Start Date')</th>
      <th>@lang('cars::delegations.End Date')</th>
    </tr>
  </thead>
  <tbody>
    @forelse($car->delegations as $d)
      <tr>
        <td>{{ optional($d->employee)->name }}</td>
        <td>{{ $d->type?->{app()->getLocale() === 'ar' ? 'name_ar' : 'name_en'} }}</td>
        <td>{{ $d->start_date }}<br><small class="text-muted">{{ $d->start_date_hijri }}</small></td>
        <td>{{ $d->end_date }}<br><small class="text-muted">{{ $d->end_date_hijri }}</small></td>
      </tr>
    @empty
      <tr><td colspan="4" class="text-center text-muted">@lang('cars::delegations.No data')</td></tr>
    @endforelse
  </tbody>
</table>
