@php use Illuminate\Support\Facades\Storage; @endphp
<div class="card mt-4" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">@lang('documents::documents.documents')</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('hr.employees.documents.store', $employee) }}" enctype="multipart/form-data" class="row g-2 mb-3">
            @csrf
            <div class="col-md-3">
                <input type="text" name="type" class="form-control" placeholder="@lang('documents::documents.type')" required>
            </div>
            <div class="col-md-3">
                <input type="text" name="number" class="form-control" placeholder="@lang('documents::documents.number')">
            </div>
            <div class="col-md-3">
                <input type="date" name="expire_at" class="form-control" placeholder="@lang('documents::documents.expire_at')">
            </div>
            <div class="col-md-3">
                <input type="file" name="file" class="form-control">
            </div>
            <div class="col-12">
                <button class="btn btn-primary btn-sm">@lang('documents::documents.upload')</button>
            </div>
        </form>

        @if($documents->count())
        <div class="table-responsive">
            <table class="table table-sm align-middle">
                <thead>
                    <tr>
                        <th>@lang('documents::documents.type')</th>
                        <th>@lang('documents::documents.expire_at')</th>
                        <th>@lang('documents::documents.file')</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($documents as $doc)
                    @php
                        $days = $doc->days_left;
                        $color = 'primary';
                        if(!is_null($days)){
                            if($days <= 7) $color = 'danger';
                            elseif($days <= 30) $color = 'warning';
                        }
                    @endphp
                    <tr>
                        <td>{{ $doc->type }}</td>
                        <td>
                            @if(!is_null($days))
                                <span class="badge bg-{{ $color }}">{{ $days }}</span>
                            @endif
                            {{ $doc->expire_at?->format('Y-m-d') }}
                        </td>
                        <td>
                            @if($doc->file_path)
                                <a href="{{ Storage::url($doc->file_path) }}" target="_blank">@lang('documents::documents.file')</a>
                            @endif
                        </td>
                        <td>
                            <form method="POST" action="{{ route('hr.documents.destroy', $doc) }}" onsubmit="return confirm('@lang('documents::documents.delete_confirm')');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">@lang('documents::documents.delete')</button>
                            </form>
                        </td>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
            <p class="text-muted">@lang('documents::documents.none')</p>
        @endif
    </div>
</div>
