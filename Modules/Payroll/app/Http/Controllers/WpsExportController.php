<?php

namespace Modules\Payroll\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Modules\Payroll\Actions\GenerateWpsCsvFromPayrollRun;

class WpsExportController extends Controller
{
    public function export($runId)
    {
        try {
            $path = (new GenerateWpsCsvFromPayrollRun())->handle($runId);
            return Storage::download($path);
        } catch (\Exception $e) {
            return back()->with('error', __('app.Validation errors'));
        }
    }
}
