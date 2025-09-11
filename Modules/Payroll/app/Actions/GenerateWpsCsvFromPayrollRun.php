<?php

namespace Modules\Payroll\Actions;

use Illuminate\Support\Facades\Storage;
use Modules\Payroll\Models\PayrollRun;
use Modules\Payroll\Models\WpsFile;

class GenerateWpsCsvFromPayrollRun
{
    public function handle(int $runId): string
    {
        $run = PayrollRun::with(['items.employee','company'])->findOrFail($runId);
        $config = config('wps');

        $rows = [];
        $rows[] = implode(',', $config['header']);

        foreach ($run->items as $item) {
            $line = [];
            foreach ($config['columns'] as $callback) {
                $line[] = $callback($item);
            }
            $rows[] = implode(',', $line);
        }

        $content = implode("\n", $rows);
        $path = 'wps/' . $run->month . '_' . $run->id . '.csv';
        Storage::put($path, $content);

        WpsFile::create([
            'payroll_run_id' => $run->id,
            'file_path' => $path,
            'meta' => ['generated_at' => now()],
        ]);

        return $path;
    }
}
