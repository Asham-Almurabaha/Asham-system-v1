<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class AuditLogController extends Controller
{
    public function index()
    {
        $logs = AuditLog::with('user')->orderByDesc('performed_at')->paginate(20);
        return view('audit-logs.index', compact('logs'));
    }

    public function show(AuditLog $auditLog)
    {
        return view('audit-logs.show', compact('auditLog'));
    }

    public function revert(AuditLog $auditLog)
    {
        $table = $auditLog->table_name;
        $id = $auditLog->record_id;

        if ($auditLog->action === 'INSERT') {
            DB::table($table)->where('id', $id)->delete();
        } elseif ($auditLog->action === 'UPDATE') {
            $data = $this->normalizeTimestamps($auditLog->old_values ?? []);
            DB::table($table)->where('id', $id)->update($data);
        } elseif ($auditLog->action === 'DELETE') {
            $data = $this->normalizeTimestamps($auditLog->old_values ?? []);
            if (! isset($data['id'])) {
                $data['id'] = $id;
            }
            DB::table($table)->insert($data);
        }

        return redirect()->back();
    }

    protected function normalizeTimestamps(array $data): array
    {
        foreach ($data as $key => $value) {
            if (Str::endsWith($key, '_at') && $value) {
                $data[$key] = Carbon::parse($value)->format('Y-m-d H:i:s');
            }
        }

        return $data;
    }
}
