<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Services\ActivityLogger;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $logs = ActivityLog::query()
            ->latest('id')
            ->paginate(20)
            ->appends($request->query());

        return view('activity_logs.index', compact('logs'));
    }

    public function show(ActivityLog $log)
    {
        return view('activity_logs.show', compact('log'));
    }

    public function revert(Request $request, ActivityLog $log)
    {
        if ($log->operation_type !== 'updated') {
            return back()->withErrors(__('Only update events can be reverted.'));
        }

        $class = $log->subject_type;
        $id    = $log->subject_id;

        if (!$class || !class_exists($class) || !is_subclass_of($class, EloquentModel::class)) {
            return back()->withErrors(__('Subject model not available.'));
        }

        /** @var EloquentModel|null $model */
        $model = $class::query()->find($id);
        if (!$model) {
            return back()->withErrors(__('The original record no longer exists.'));
        }

        $changes = $log->changes;
        if (empty($changes)) {
            return back()->withErrors(__('No change details to revert.'));
        }

        $before = $log->value_before ?? [];
        $revertData = [];
        foreach ($changes as $k => $diff) {
            $revertData[$k] = $before[$k] ?? null;
        }

        $model->forceFill($revertData);
        $model->save();

        ActivityLogger::log('reverted', $model, 'Reverted changes from activity log #'.$log->id, [
            'reverted_keys' => array_keys($revertData),
            'activity_log_id' => $log->id,
        ], operationType: 'reverted', before: $log->value_after, after: $revertData);

        return redirect()->route('activity-logs.show', $log)->with('success', __('Changes reverted successfully.'));
    }
}
