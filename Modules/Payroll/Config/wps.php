<?php

return [
    'company' => [
        'name_ar' => env('WPS_COMPANY_NAME_AR'),
        'name_en' => env('WPS_COMPANY_NAME_EN'),
        'iban' => env('WPS_COMPANY_IBAN'),
        'cr' => env('WPS_COMPANY_CR'),
    ],
    'columns' => [
        'employee_code' => fn ($item) => $item->employee->code ?? '',
        'name_ar' => fn ($item) => trim(($item->employee->first_name_ar ?? '').' '.($item->employee->last_name_ar ?? '')),
        'name_en' => fn ($item) => trim(($item->employee->first_name ?? '').' '.($item->employee->last_name ?? '')),
        'national_id' => fn ($item) => $item->employee->national_id ?? '',
        'iban' => fn ($item) => $item->employee->iban ?? '',
        'month' => fn ($item) => $item->run->month,
        'basic' => fn ($item) => $item->basic,
        'allowances_total' => fn ($item) => array_sum($item->allowances ?? []),
        'deductions_total' => fn ($item) => array_sum($item->deductions ?? []),
        'overtime' => fn ($item) => $item->overtime_amount,
        'net' => fn ($item) => $item->net,
    ],
    'header' => [
        'Emp Code',
        'Name (AR)',
        'Name (EN)',
        'National ID',
        'IBAN',
        'Month',
        'Basic',
        'Allowances',
        'Deductions',
        'Overtime',
        'Net',
    ],
];
