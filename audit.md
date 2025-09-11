# Audit

## Migrations
- database/migrations/0001_01_01_000000_create_users_table.php
- database/migrations/0001_01_01_000002_create_cache_table.php
- database/migrations/0001_01_01_000003_create_jobs_table.php
- database/migrations/0001_01_01_000004_create_permission_tables.php
- database/migrations/2025_09_05_000140_add_branch_id_to_users_table.php

## Models
- app/Models/User.php
- Modules/Nationalities/app/Models/Nationality.php
- Modules/Employees/app/Models/Employee.php
- Modules/Employees/app/Models/EmployeeResidency.php
- Modules/Employees/app/Models/EmployeePhone.php
- Modules/Cities/app/Models/City.php
- Modules/ResidencyStatuses/app/Models/ResidencyStatus.php
- Modules/Settings/app/Models/Setting.php
- Modules/AuditLogs/app/Models/AuditLog.php
- Modules/WorkStatuses/app/Models/WorkStatus.php
 - Modules/Org/Models/Company.php
 - Modules/Org/Models/Branch.php
 - Modules/Org/Models/Department.php
 - Modules/Org/Models/Title.php

## Routes
- routes/web.php
- routes/api.php
- routes/console.php
- Modules/*/routes/web.php & api.php (Nationalities, Employees, Cities, ResidencyStatuses, Settings, Profiles, AuditLogs, WorkStatuses)

## Views
- Modules/*/resources/views/* (Nationalities, Employees, Cities, ResidencyStatuses, Settings, Profiles, AuditLogs, WorkStatuses)

## Translations
- resources/lang/en/*
- resources/lang/ar/*
- resources/lang/vendor/backup/*
- Modules/*/lang/en/* and ar/* (Nationalities, Employees, Cities, ResidencyStatuses, Settings, Profiles, AuditLogs, WorkStatuses)

## Scheduling
- app/Console/Kernel.php schedules hr:check-document-expiry daily at 09:00 Asia/Riyadh.
