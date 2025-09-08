<?php

namespace Modules\Employees\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Employees\Models\Employee;
use Modules\Branches\Models\Branch;
use Modules\Departments\Models\Department;
use Modules\Titles\Models\Title;
use Modules\Nationalities\Models\Nationality;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $branch = Branch::first();
        $department = Department::first();
        $title = Title::first();
        $nationality = Nationality::first();

        if (! $branch || ! $department || ! $title || ! $nationality) {
            return;
        }

        $data = [
            [
                'first_name' => 'Ahmed',
                'first_name_ar' => 'أحمد',
                'last_name' => 'Hassan',
                'last_name_ar' => 'حسن',
                'email' => 'ahmed@example.com',
                'hire_date' => '2022-01-10',
                'branch_id' => $branch->id,
                'department_id' => $department->id,
                'title_id' => $title->id,
                'nationality_id' => $nationality->id,
                'phones' => ['0500000001', '0555555555'],
                'residencies' => [
                    [
                        'absher_id_image' => 'ahmed_absher.png',
                        'tawakkalna_id_image' => 'ahmed_tawakkalna.png',
                        'expiry_date' => '2025-12-31',
                        'employer_name' => 'Company A',
                        'employer_id' => '1234567890',
                    ],
                ],
            ],
            [
                'first_name' => 'Sara',
                'first_name_ar' => 'سارة',
                'last_name' => 'Ali',
                'last_name_ar' => 'علي',
                'email' => 'sara@example.com',
                'hire_date' => '2023-03-15',
                'branch_id' => $branch->id,
                'department_id' => $department->id,
                'title_id' => $title->id,
                'nationality_id' => $nationality->id,
                'phones' => ['0500000002'],
                'residencies' => [
                    [
                        'absher_id_image' => 'sara_absher.png',
                        'tawakkalna_id_image' => 'sara_tawakkalna.png',
                        'expiry_date' => '2024-06-30',
                        'employer_name' => 'Company B',
                        'employer_id' => '9876543210',
                    ],
                ],
            ],
        ];

        foreach ($data as $row) {
            $phones = $row['phones'];
            $residencies = $row['residencies'] ?? [];
            unset($row['phones'], $row['residencies']);
            $employee = Employee::firstOrCreate(
                ['email' => $row['email']],
                $row + ['is_active' => true]
            );
            foreach ($phones as $phone) {
                $employee->phones()->firstOrCreate(['phone' => $phone]);
            }
            foreach ($residencies as $residency) {
                $employee->residencies()->create($residency);
            }
        }
    }
}
